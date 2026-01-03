@extends('layouts.admin')

@section('title', 'Order #' . $order->order_number)

@section('content')
    <div class="pb-20">
        <!-- Sticky Header -->
        <div
            class="sticky top-0 z-10 bg-neutral-100/95 backdrop-blur-sm border-b border-neutral-200 -mx-4 sm:-mx-6 md:-mx-8 px-4 sm:px-6 md:px-8 py-4 mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-leather-900">Order #{{ $order->order_number }}</h1>
                <p class="text-sm text-neutral-500">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.orders.index') }}"
                    class="px-4 py-2 text-sm font-medium text-neutral-600 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-colors">
                    Back to Orders
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Order Items -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-neutral-100">
                        <h2 class="text-lg font-semibold text-leather-900">Order Items</h2>
                    </div>
                    <div class="divide-y divide-neutral-100">
                        @foreach($order->items as $item)
                            <div class="p-6 flex items-center">
                                <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-lg border border-neutral-200">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product_name }}"
                                            class="h-full w-full object-cover object-center">
                                    @else
                                        <div class="h-full w-full bg-neutral-100 flex items-center justify-center text-neutral-400">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-6 flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-medium text-leather-900">{{ $item->product_name }}</h3>
                                        <p class="text-sm font-medium text-leather-900">Rs.
                                            {{ number_format($item->subtotal, 2) }}</p>
                                    </div>
                                    <p class="mt-1 text-sm text-neutral-500">Qty: {{ $item->quantity }} x Rs.
                                        {{ number_format($item->price, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="bg-neutral-50 px-6 py-6 border-t border-neutral-100">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-neutral-500">Subtotal</span>
                            <span class="font-medium text-leather-900">Rs. {{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-neutral-500">Shipping</span>
                            <span class="font-medium text-leather-900">Rs.
                                {{ number_format($order->shipping_cost, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-base font-bold pt-4 border-t border-neutral-200 mt-4">
                            <span class="text-leather-900">Total</span>
                            <span class="text-gold-600">Rs. {{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Status Card -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-neutral-100">
                        <h2 class="text-lg font-semibold text-leather-900">Order Status</h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="space-y-4">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-neutral-700 mb-2">Current
                                        Status</label>
                                    <select name="status" id="status"
                                        class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                            Processing</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped
                                        </option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                            Delivered</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                </div>
                                <button type="submit"
                                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-leather-900 hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">
                                    Update Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Customer Details -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-neutral-100">
                        <h2 class="text-lg font-semibold text-leather-900">Customer Details</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <h3 class="text-xs font-semibold text-neutral-500 uppercase tracking-wider">Contact Info</h3>
                            <p class="mt-1 text-sm text-leather-900">{{ $order->customer_name }}</p>
                            <p class="text-sm text-neutral-600">{{ $order->customer_email }}</p>
                            <p class="text-sm text-neutral-600">{{ $order->customer_phone }}</p>
                        </div>
                        <div class="pt-4 border-t border-neutral-100">
                            <h3 class="text-xs font-semibold text-neutral-500 uppercase tracking-wider">Shipping Address
                            </h3>
                            <p class="mt-1 text-sm text-neutral-600">{{ $order->shipping_address }}</p>
                            <p class="text-sm text-neutral-600">{{ $order->city }}, {{ $order->postal_code }}</p>
                        </div>
                        @if($order->notes)
                            <div class="pt-4 border-t border-neutral-100">
                                <h3 class="text-xs font-semibold text-neutral-500 uppercase tracking-wider">Order Notes</h3>
                                <p class="mt-1 text-sm text-neutral-600 italic">"{{ $order->notes }}"</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection