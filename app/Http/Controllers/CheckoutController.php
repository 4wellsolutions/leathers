<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if(count($cart) == 0) {
            return redirect()->route('cart.index');
        }
        
        $subtotal = 0;
        foreach($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        // Calculate shipping
        $shippingCost = \App\Models\ShippingRule::getShippingCost($subtotal);
        $total = $subtotal + $shippingCost;
        
        return view('checkout.index', compact('cart', 'subtotal', 'shippingCost', 'total'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns',
            'phone' => ['required', 'regex:/^[0-9+\-\s()]{10,15}$/'],
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|digits:5',
            'notes' => 'nullable|string|max:1000',
        ], [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'phone.required' => 'Phone number is required',
            'phone.regex' => 'Please enter a valid phone number (10-15 digits)',
            'address.required' => 'Street address is required',
            'city.required' => 'City is required',
            'postal_code.required' => 'Postal code is required',
            'postal_code.digits' => 'Postal code must be exactly 5 digits',
        ]);
        
        $cart = session()->get('cart');
        $subtotal = 0;
        foreach($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        // Calculate shipping
        $shippingCost = \App\Models\ShippingRule::getShippingCost($subtotal);
        $total = $subtotal + $shippingCost;
        
        $order = \App\Models\Order::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'customer_name' => $request->first_name . ' ' . $request->last_name,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'shipping_address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'total' => $total,
            'status' => 'pending',
            'notes' => $request->notes
        ]);
        
        foreach($cart as $id => $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity']
            ]);
            
            // Decrease stock
            $product = \App\Models\Product::find($id);
            if($product) {
                $product->decrement('stock', $item['quantity']);
            }
        }
        
        session()->forget('cart');
        
        // Load items relationship and dispatch email job
        $order->load('items.product');
        \App\Jobs\SendOrderPlacedEmail::dispatch($order);
        
        return redirect()->route('checkout.success', $order->order_number);
    }
    
    public function success($order_number)
    {
        $order = \App\Models\Order::where('order_number', $order_number)->firstOrFail();
        return view('checkout.success', compact('order'));
    }
}
