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
            \Illuminate\Support\Facades\Mail::to($order->customer_email)->send(new \App\Mail\OrderConfirmed($order));
        } elseif ($request->status === 'shipped' && $oldStatus !== 'shipped') {
            \Illuminate\Support\Facades\Mail::to($order->customer_email)->send(new \App\Mail\OrderShipped($order));
        } elseif ($request->status === 'delivered' && $oldStatus !== 'delivered') {
            \Illuminate\Support\Facades\Mail::to($order->customer_email)->send(new \App\Mail\OrderDelivered($order));
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully'
            ]);
        }

        return back()->with('success', 'Order status updated successfully');
    }

    public function resendEmail(Request $request, \App\Models\Order $order)
    {
        $request->validate([
            'type' => 'required|in:placed,confirmed,shipped,delivered',
        ]);

        $order->load('items.product');

        try {
            switch ($request->type) {
                case 'placed':
                    \Illuminate\Support\Facades\Mail::to($order->customer_email)->send(new \App\Mail\OrderPlaced($order));
                    break;
                case 'confirmed':
                    \Illuminate\Support\Facades\Mail::to($order->customer_email)->send(new \App\Mail\OrderConfirmed($order));
                    break;
                case 'shipped':
                    \Illuminate\Support\Facades\Mail::to($order->customer_email)->send(new \App\Mail\OrderShipped($order));
                    break;
                case 'delivered':
                    \Illuminate\Support\Facades\Mail::to($order->customer_email)->send(new \App\Mail\OrderDelivered($order));
                    break;
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Email notification has been sent.'
                ]);
            }

            return back()->with('success', 'Email has been sent.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send email: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }
}
