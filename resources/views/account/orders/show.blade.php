@extends('layouts.app')

@section('title', 'Order #' . $order->order_number)

@section('content')
@section('content')
    <!-- Web View (Hidden on Print) -->
    <div x-data="{ showModal: false, modalImage: '', openModal(img) { this.modalImage = img; this.showModal = true; } }" 
         class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 print:hidden">
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
            <div class="p-4 border-b border-neutral-100 bg-neutral-50/30">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                    <div class="space-y-2">
                        <!-- Badge & ID -->
                        <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4">
                            <h1 class="text-2xl md:text-3xl font-serif font-bold text-leather-900">Order #{{ $order->order_number }}</h1>
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                                    @if($order->status == 'delivered') bg-green-100 text-green-800
                                    @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                    @else bg-gold-100 text-gold-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <a href="{{ route('my-orders.invoice', $order->order_number) }}" target="_blank" class="hidden md:inline-flex items-center px-3 py-1 bg-neutral-100 text-neutral-600 rounded-lg hover:bg-neutral-200 transition-colors text-xs font-bold uppercase tracking-wider">
                                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                    Invoice
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center text-sm text-neutral-500 gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex">
                        <a href="{{ route('my-orders.invoice', $order->order_number) }}" target="_blank" class="w-full md:w-auto px-5 py-2.5 border border-neutral-200 bg-white rounded-lg text-sm font-bold text-neutral-700 hover:bg-neutral-50 hover:border-neutral-300 transition-all shadow-sm flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Print Invoice
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-4 md:p-6 grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12">
                <!-- Left Column: Order Items -->
                <div class="lg:col-span-2 space-y-8">
                    <div>
                        <h3 class="text-lg font-bold text-leather-900 mb-6 pb-2 border-b border-neutral-100">Items Ordered</h3>
                        <div class="space-y-8">
                            @foreach($order->items as $item)
                                <div class="flex flex-row gap-4 sm:gap-6 pb-6 sm:pb-8 border-b border-neutral-100 last:border-0 last:pb-0 items-start">
                                    <!-- Premium Image Container -->
                                    <div class="w-20 h-20 sm:w-28 sm:h-28 bg-white rounded-xl shadow-sm border border-neutral-100 flex-shrink-0 p-2 overflow-hidden relative group cursor-pointer"
                                         @click="openModal('{{ asset($item->product && $item->product->images && count($item->product->images) > 0 ? $item->product->images[0] : 'images/placeholder.jpg') }}')">
                                        @if($item->product && $item->product->images && count($item->product->images) > 0)
                                            <img src="{{ asset($item->product->images[0]) }}" alt="{{ $item->product_name }}" 
                                                 class="w-full h-full object-contain transform group-hover:scale-110 transition-transform duration-500">
                                            <!-- Zoom Icon Overlay -->
                                            <div class="absolute inset-0 bg-black/5 items-center justify-center hidden group-hover:flex transition-all">
                                                <svg class="w-6 h-6 text-white drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m-3-3h6" />
                                                </svg>
                                            </div>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-neutral-300 bg-neutral-50 rounded-lg">
                                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Content -->
                                    <div class="flex-grow w-full">
                                        <div class="flex flex-col gap-1 sm:gap-3">
                                            <div>
                                                @php
                                                    $nameParts = explode(' - ', $item->product_name, 2);
                                                    $baseName = $nameParts[0];
                                                    $variantDetail = $nameParts[1] ?? null;
                                                @endphp
                                                
                                                <h4 class="font-serif font-bold text-leather-900 text-base sm:text-xl leading-snug line-clamp-2">{{ $baseName }}</h4>
                                                
                                                <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-2">
                                                    @if($variantDetail)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] sm:text-xs font-bold bg-neutral-900 text-white shadow-sm">
                                                            {{ $variantDetail }}
                                                        </span>
                                                        <span class="text-neutral-300 text-xs hidden sm:inline">|</span>
                                                    @endif
                                                    
                                                    <div class="text-xs sm:text-sm font-medium text-neutral-600 bg-neutral-50 px-2 py-1 rounded">
                                                        Qty: <span class="text-leather-900 font-bold">{{ $item->quantity }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="flex justify-between items-end border-t border-neutral-50 pt-2 mt-1 sm:border-0 sm:pt-0 sm:mt-0 sm:block sm:text-right">
                                                <p class="text-[10px] text-neutral-400 uppercase tracking-wide mb-0.5 sm:mb-1">Total</p>
                                                <p class="text-lg sm:text-xl font-serif font-bold text-leather-900">
                                                    Rs. {{ number_format($item->subtotal) }}
                                                </p>
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

        <!-- Image Modal -->
        <div x-show="showModal" style="display: none;" 
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-sm p-4 cursor-pointer"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click.self="showModal = false">
            
            <div class="relative max-w-4xl max-h-[90vh]">
                <!-- Close Button -->
                <button @click="showModal = false" class="absolute -top-12 -right-4 md:-right-12 text-white hover:text-gold-500 transition-colors p-2">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <img :src="modalImage" alt="Product Zoom" class="max-w-full max-h-[85vh] rounded-lg shadow-2xl object-contain">
            </div>
        </div>
    </div>

@endsection