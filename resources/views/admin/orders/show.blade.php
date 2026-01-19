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
                <button onclick="window.print()"
                    class="px-4 py-2 text-sm font-medium text-leather-900 bg-white border border-leather-300 rounded-lg hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Order
                </button>
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
                    <div class="px-6 py-4 border-b border-neutral-100 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-leather-900">Order Items</h2>
                        <span class="text-xs font-medium text-neutral-500">{{ $order->items->count() }} Item(s)</span>
                    </div>
                    <div class="divide-y divide-neutral-100">
                        @foreach($order->items as $item)
                            <div class="p-6 flex items-center">
                                <div
                                    class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-lg border border-neutral-200 bg-neutral-50 p-2">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product_name }}"
                                            class="h-full w-full object-contain object-center">
                                    @else
                                        <div class="h-full w-full bg-neutral-100 flex items-center justify-center text-neutral-400">
                                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-6 flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            @if($item->product)
                                                <a href="{{ route('products.show', $item->product->slug) }}" target="_blank"
                                                    class="text-sm font-semibold text-gold-600 hover:text-gold-900 transition-colors">
                                                    {{ $item->product_name }}
                                                </a>
                                            @else
                                                <h3 class="text-sm font-semibold text-leather-900">{{ $item->product_name }}</h3>
                                            @endif

                                        </div>
                                        <p class="text-sm font-bold text-leather-900">Rs.
                                            {{ number_format($item->subtotal, 2) }}
                                        </p>
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-neutral-500">
                                        <span>{{ $item->quantity }} x Rs. {{ number_format($item->price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="bg-neutral-50 px-6 py-6 border-t border-neutral-100">
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-500">Subtotal</span>
                                <span class="font-medium text-leather-900">Rs.
                                    {{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-500">Shipping</span>
                                <span class="font-medium text-leather-900">
                                    @if($order->shipping_cost > 0)
                                        Rs. {{ number_format($order->shipping_cost, 2) }}
                                    @else
                                        <span class="text-green-600">Free Shipping</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between text-lg font-bold pt-4 border-t border-neutral-200 mt-4">
                                <span class="text-leather-900">Total Amount</span>
                                <span class="text-gold-600">Rs. {{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Activity / History (Placeholder for now) -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-neutral-100">
                        <h2 class="text-lg font-semibold text-leather-900">Payment Information</h2>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center">
                            <div
                                class="h-10 w-10 rounded-full bg-leather-100 flex items-center justify-center text-leather-600 mr-4">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-leather-900">Cash on Delivery (COD)</p>
                                <p class="text-xs text-neutral-500">Pay when order is delivered to your doorstep.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Status Card -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-neutral-100">
                        <h2 class="text-lg font-semibold text-leather-900">Update Order Status</h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="space-y-4">
                                <div>
                                    <label for="status"
                                        class="block text-sm font-medium text-neutral-700 mb-2 text-center bg-neutral-50 py-2 rounded border border-neutral-100">
                                        Current Status: <span
                                            class="uppercase font-bold text-leather-900">{{ $order->status }}</span>
                                    </label>
                                    <select name="status" id="status"
                                        class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4 transition-all">
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
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-leather-900 hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-all uppercase tracking-wider">
                                    Update Status
                                </button>
                                <p class="text-[10px] text-center text-neutral-400">Updating status will send an automated
                                    email to the customer.</p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Manual Email Resend -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-neutral-100">
                        <h2 class="text-lg font-semibold text-leather-900">Resend Email Notifications</h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.orders.resend-email', $order->id) }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <select name="type" required
                                        class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4 transition-all">
                                        <option value="placed">New Order Email (Placed)</option>
                                        <option value="confirmed">Order Processing Email (Confirmed)</option>
                                        <option value="shipped">Order Dispatched Email (Shipped)</option>
                                        <option value="delivered">Order Delivered Email (Delivered)</option>
                                    </select>
                                </div>
                                <button type="submit"
                                    class="w-full flex justify-center py-3 px-4 border border-leather-900 rounded-lg shadow-sm text-sm font-bold text-leather-900 bg-white hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-all uppercase tracking-wider">
                                    Resend Notification
                                </button>
                                <p class="text-[10px] text-center text-neutral-400 italic">Use this if the customer didn't
                                    receive their initial email.</p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Customer Details -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-neutral-100 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-leather-900">Customer Info</h2>

                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <h3 class="text-xs font-bold text-neutral-400 uppercase tracking-widest mb-3">Contact Details
                            </h3>
                            <div class="flex items-center mb-2">
                                <svg class="w-4 h-4 text-neutral-400 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="text-sm font-medium text-leather-900">{{ $order->customer_name }}</span>
                            </div>
                            <div class="flex items-center mb-2">
                                <svg class="w-4 h-4 text-neutral-400 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <a href="mailto:{{ $order->customer_email }}"
                                    class="text-sm text-gold-600 hover:text-gold-900 transition-colors">{{ $order->customer_email }}</a>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-neutral-400 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span class="text-sm text-leather-900">{{ $order->customer_phone }}</span>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-neutral-100">
                            <h3 class="text-xs font-bold text-neutral-400 uppercase tracking-widest mb-3">Shipping Address
                            </h3>
                            <div class="bg-neutral-50 p-4 rounded-lg border border-neutral-100">
                                <p class="text-sm text-leather-800 leading-relaxed">
                                    {{ $order->shipping_address }}<br>
                                    <span class="font-bold">{{ $order->city }}</span>
                                    @if($order->postal_code && $order->postal_code !== '00000')
                                        , {{ $order->postal_code }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if($order->notes)
                            <div class="pt-6 border-t border-neutral-100">
                                <h3 class="text-xs font-bold text-neutral-400 uppercase tracking-widest mb-2">Order Notes</h3>
                                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                                    <p class="text-sm text-yellow-800 italic leading-relaxed">"{{ $order->notes }}"</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection