<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class UserOrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Order::where(function ($q) use ($user) {
            $q->where('customer_email', $user->email);
            if ($user->phone) {
                $q->orWhere('customer_phone', $user->phone);
            }
        });

        // Filter by Status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);
        $orders->appends($request->all()); // Keep filters in pagination links

        return view('account.orders.index', compact('orders'));
    }

    public function show($order_number)
    {
        $user = Auth::user();

        $order = Order::where('order_number', $order_number)
            ->where(function ($q) use ($user) {
                $q->where('customer_email', $user->email);
                if ($user->phone) {
                    $q->orWhere('customer_phone', $user->phone);
                }
            })
            ->with('items.product') // Eager load items and products
            ->firstOrFail();

        return view('account.orders.show', compact('order'));
    }
}
