@extends('layouts.app')

@section('title', 'Order #' . $order->order_number)

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Back Button -->
        <a href="{{ route('my-orders.index') }}"
            class="inline-flex items-center text-neutral-500 hover:text-gold-600 mb-6 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Orders
        </a>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-neutral-100">
            <!-- Header -->
            <div
                class="px-6 py-6 border-b border-neutral-100 bg-neutral-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h1 class="text-2xl font-serif font-bold text-leather-900">Order #{{ $order->order_number }}</h1>
                        @php
                            $statusClasses = [
                                'pending' => 'bg-gold-100 text-gold-800',
                                'processing' => 'bg-blue-100 text-blue-800',
                                'shipped' => 'bg-purple-100 text-purple-800',
                                'delivered' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                            $statusClass = $statusClasses[$order->status] ?? 'bg-neutral-100 text-neutral-800';
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide {{ $statusClass }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <p class="text-sm text-neutral-500">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                </div>

                <div class="flex gap-3 print:hidden">
                    <button onclick="window.print()"
                        class="px-4 py-2 border border-neutral-300 rounded-lg text-sm font-medium text-neutral-600 hover:bg-neutral-50 transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Print Invoice
                    </button>
                </div>
            </div>

            <div class="p-6 md:p-8 grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12">
                <!-- Left Column: Order Items -->
                <div class="lg:col-span-2 space-y-8">
                    <div>
                        <h3 class="text-lg font-bold text-leather-900 mb-4 pb-2 border-b border-neutral-100">Items Ordered
                        </h3>
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div
                                    class="flex gap-4 p-4 border border-neutral-100 rounded-lg hover:shadow-sm transition-shadow">
                                    <!-- Product Image -->
                                    <div
                                        class="w-20 h-20 bg-neutral-50 rounded-md border border-neutral-200 flex-shrink-0 overflow-hidden">
                                        @if($item->product && $item->product->images && count($item->product->images) > 0)
                                            <img src="{{ asset($item->product->images[0]) }}" alt="{{ $item->product_name }}"
                                                class="w-full h-full object-contain p-1">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-neutral-300">
                                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-grow flex flex-col justify-center">
                                        <h4 class="font-bold text-leather-900 text-lg">{{ $item->product_name }}</h4>
                                        <div class="flex justify-between items-end mt-2">
                                            <div class="text-sm text-neutral-500">
                                                <span class="bg-neutral-100 px-2 py-1 rounded text-xs font-semibold mr-2">Qty:
                                                    {{ $item->quantity }}</span>
                                                <span>Unit Price: Rs. {{ number_format($item->price) }}</span>
                                            </div>
                                            <div class="text-lg font-bold text-leather-900 font-serif">
                                                Rs. {{ number_format($item->subtotal) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Customer Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3
                                class="text-sm font-bold text-neutral-400 uppercase tracking-wider mb-4 border-b border-neutral-100 pb-2">
                                Shipping Details</h3>
                            <div class="text-neutral-700 space-y-1">
                                <p class="font-bold text-leather-900 text-lg">{{ $order->customer_name }}</p>
                                <p>{{ $order->shipping_address }}</p>
                                <p>{{ $order->city }}</p>
                                <p class="pt-2 text-sm text-neutral-500">{{ $order->customer_phone }}</p>
                                <p class="text-sm text-neutral-500">{{ $order->customer_email }}</p>
                            </div>
                        </div>
                        <div>
                            <h3
                                class="text-sm font-bold text-neutral-400 uppercase tracking-wider mb-4 border-b border-neutral-100 pb-2">
                                Order Notes</h3>
                            <p
                                class="text-neutral-600 italic bg-neutral-50 p-4 rounded-lg text-sm border border-neutral-100">
                                {{ $order->notes ?: 'No special instructions provided.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Summary -->
                <div>
                    <div class="bg-neutral-50 rounded-xl p-6 border border-neutral-200">
                        <h3 class="text-lg font-bold text-leather-900 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gold-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            Order Summary
                        </h3>

                        <div class="space-y-4">
                            <div class="flex justify-between text-neutral-600">
                                <span>Subtotal</span>
                                <span class="font-medium text-leather-900">Rs. {{ number_format($order->subtotal) }}</span>
                            </div>
                            <div class="flex justify-between text-neutral-600">
                                <span>Shipping</span>
                                @if($order->shipping_cost > 0)
                                    <span class="font-medium text-leather-900">Rs.
                                        {{ number_format($order->shipping_cost) }}</span>
                                @else
                                    <span class="font-bold text-green-600 text-sm bg-green-50 px-2 py-0.5 rounded">FREE</span>
                                @endif
                            </div>

                            <div class="border-t border-neutral-200 pt-4 mt-2">
                                <div class="flex justify-between items-end">
                                    <span class="font-bold text-leather-900 text-lg">Total</span>
                                    <span class="font-bold text-gold-600 text-2xl font-serif">Rs.
                                        {{ number_format($order->total) }}</span>
                                </div>
                                <p class="text-right text-xs text-neutral-400 mt-1">Included VAT & Taxes</p>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-neutral-200">
                            <h4 class="text-xs font-bold text-neutral-400 uppercase tracking-wider mb-2">Payment Method</h4>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-gold-500"></span>
                                <span class="font-medium text-leather-900">Cash On Delivery</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-xs text-neutral-400">Need help with this order?</p>
                        <a href="{{ route('contact') }}"
                            class="text-sm font-bold text-gold-600 hover:text-gold-700 hover:underline">Contact Support</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection