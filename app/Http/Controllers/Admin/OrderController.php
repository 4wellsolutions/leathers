<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Order::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Amount range filter
        if ($request->filled('amount_min')) {
            $query->where('total', '>=', $request->amount_min);
        }
        if ($request->filled('amount_max')) {
            $query->where('total', '<=', $request->amount_max);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Stats
        $stats = [
            'total' => \App\Models\Order::count(),
            'pending' => \App\Models\Order::where('status', 'pending')->count(),
            'processing' => \App\Models\Order::where('status', 'processing')->count(),
            'delivered' => \App\Models\Order::where('status', 'delivered')->count(),
            'revenue' => \App\Models\Order::where('status', 'delivered')->sum('total'),
        ];

        $orders = $query->latest()->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show(\App\Models\Order $order)
    {
        $order->load(['items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, \App\Models\Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Load relationships for email
        $order->load('items.product');

        // Dispatch appropriate email based on status change
        if ($request->status === 'processing' && $oldStatus !== 'processing') {
            \App\Jobs\SendOrderConfirmedEmail::dispatch($order);
        } elseif ($request->status === 'shipped' && $oldStatus !== 'shipped') {
            \App\Jobs\SendOrderShippedEmail::dispatch($order);
        } elseif ($request->status === 'delivered' && $oldStatus !== 'delivered') {
            \App\Jobs\SendOrderDeliveredEmail::dispatch($order);
        }

        return back()->with('success', 'Order status updated successfully');
    }
}
