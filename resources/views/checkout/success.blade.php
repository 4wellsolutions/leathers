@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
        <div class="inline-block p-6 rounded-full bg-green-100 text-green-600 mb-8 animate-scale-in">
            <svg class="w-20 h-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h1 class="text-4xl font-serif font-bold text-leather-900 mb-4 animate-slide-up">Thank You for Your Order!</h1>
        <p class="text-xl text-neutral-600 mb-8 animate-slide-up" style="animation-delay: 0.1s;">Your order <span
                class="font-bold text-leather-900">{{ $order->order_number }}</span> has been placed successfully.</p>

        <div class="bg-white rounded-xl shadow-lg p-8 mb-12 text-left animate-slide-up" style="animation-delay: 0.2s;">
            <h2 class="text-xl font-bold text-leather-900 mb-4 border-b border-neutral-200 pb-2">Order Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-semibold text-neutral-500 uppercase tracking-wider mb-2">Shipping Address</h3>
                    <p class="text-leather-900">{{ $order->customer_name }}</p>
                    <p class="text-neutral-600">{{ $order->shipping_address }}</p>
                    <p class="text-neutral-600">{{ $order->city }}</p>
                    <p class="text-neutral-600">{{ $order->customer_phone }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-neutral-500 uppercase tracking-wider mb-2">Order Summary</h3>
                    <div class="flex justify-between mb-1">
                        <span class="text-neutral-600">Subtotal:</span>
                        <span class="text-leather-900 font-medium">Rs. {{ number_format($order->subtotal) }}</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span class="text-neutral-600">Shipping:</span>
                        <span class="text-green-600 font-medium">Free</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-neutral-100 mt-2">
                        <span class="text-leather-900 font-bold">Total:</span>
                        <span class="text-leather-900 font-bold">Rs. {{ number_format($order->total) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="animate-slide-up" style="animation-delay: 0.3s;">
            <p class="text-neutral-600 mb-6">We'll send a confirmation email to
                <strong>{{ $order->customer_email }}</strong> with your order details and tracking information.</p>
            <a href="{{ route('home') }}" class="btn-primary">Continue Shopping</a>
        </div>
    </div>
@endsection