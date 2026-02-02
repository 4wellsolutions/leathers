@extends('layouts.app')

@section('meta_title', 'Shopping Cart - Leathers.pk')
@section('meta_description', 'Review your shopping cart at Leathers.pk. Secure checkout and free shipping on orders over Rs. 5,000.')
@section('meta_robots', 'noindex, nofollow')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-4xl font-serif font-bold text-leather-900 mb-8">Shopping Cart</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(count($cart) > 0)
            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Cart Items -->
                <div class="flex-grow">
                    <!-- Desktop Table View -->
                    <div class="hidden md:block bg-white rounded-xl shadow-lg overflow-hidden">
                        <table class="w-full">
                            <thead class="bg-leather-100 border-b border-leather-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-leather-800 uppercase tracking-wider">
                                        Product</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-leather-800 uppercase tracking-wider">
                                        Quantity</th>
                                    <th
                                        class="px-6 py-4 text-right text-xs font-bold text-leather-800 uppercase tracking-wider">
                                        Total</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-leather-800 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200">
                                @foreach($cart as $id => $details)
                                    <tr class="hover:bg-neutral-50 transition-colors" data-id="{{ $id }}">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-16 w-16 bg-neutral-100 rounded-md overflow-hidden">
                                                    <img class="h-16 w-16 object-contain p-2"
                                                        src="{{ str_starts_with($details['image'], 'http') ? $details['image'] : asset($details['image']) }}"
                                                        alt="{{ $details['name'] }}">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-leather-900">
                                                        @if(isset($details['type']) && $details['type'] == 'combo')
                                                            <a href="{{ route('combos.show', $details['slug']) }}"
                                                                class="hover:text-gold-600">{{ $details['name'] }}</a>
                                                            <p class="text-xs text-gold-600 mt-1">Bundle Deal</p>
                                                        @else
                                                            <a href="{{ route('products.show', $details['slug']) }}"
                                                                class="hover:text-gold-600">{{ $details['base_name'] ?? $details['name'] }}</a>
                                                            @if(isset($details['color']) || isset($details['size']))
                                                                <p class="text-xs text-neutral-500 mt-1 font-normal">
                                                                    @if(isset($details['color']) && $details['color']) {{ $details['color'] }} @endif
                                                                    @if(isset($details['color']) && $details['color'] && isset($details['size']) && $details['size']) / @endif
                                                                    @if(isset($details['size']) && $details['size']) {{ $details['size'] }} @endif
                                                                </p>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <div class="flex flex-col">
                                                        @if(isset($details['original_price']) && $details['original_price'] > $details['price'])
                                                            <span class="text-sm font-bold text-red-600">Rs. {{ number_format($details['price']) }}</span>
                                                            <div class="flex items-center gap-2">
                                                                <span class="text-xs text-neutral-400 line-through">Rs. {{ number_format($details['original_price']) }}</span>
                                                                <span class="text-xs font-bold text-white bg-red-600 px-1.5 py-0.5 rounded">-{{ round((($details['original_price'] - $details['price']) / $details['original_price']) * 100) }}%</span>
                                                            </div>
                                                        @else
                                                            <span class="text-sm text-neutral-500">Rs. {{ number_format($details['price']) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="inline-flex items-center border border-neutral-300 rounded-lg">
                                                <button
                                                    class="px-2 py-1 text-neutral-600 hover:text-leather-900 focus:outline-none update-cart"
                                                    data-action="decrease">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M20 12H4" />
                                                    </svg>
                                                </button>
                                                <input type="number" value="{{ $details['quantity'] }}"
                                                    class="w-12 text-center border-none focus:ring-0 p-1 text-sm font-semibold quantity-input"
                                                    min="1">
                                                <button
                                                    class="px-2 py-1 text-neutral-600 hover:text-leather-900 focus:outline-none update-cart"
                                                    data-action="increase">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-bold text-leather-900 subtotal">
                                            Rs. {{ number_format($details['price'] * $details['quantity']) }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <button class="text-red-500 hover:text-red-700 remove-from-cart" title="Remove Item">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>



                    <!-- Mobile Card View -->
                    <div class="md:hidden space-y-4">
                        @foreach($cart as $id => $details)
                            <div class="bg-white rounded-xl shadow-sm p-4 flex gap-4 cart-item" data-id="{{ $id }}">
                                <!-- Image -->
                                <div class="flex-shrink-0 w-20 h-20 bg-neutral-100 rounded-lg overflow-hidden">
                                    <img class="w-full h-full object-contain p-2"
                                        src="{{ str_starts_with($details['image'], 'http') ? $details['image'] : asset($details['image']) }}"
                                        alt="{{ $details['name'] }}">
                                </div>

                                <!-- Content -->
                                <div class="flex-grow flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-start">
                                            <h3 class="text-sm font-bold text-leather-900 line-clamp-2">
                                                @if(isset($details['type']) && $details['type'] == 'combo')
                                                    <a href="{{ route('combos.show', $details['slug']) }}">{{ $details['name'] }}</a>
                                                @else
                                                    <a href="{{ route('products.show', $details['slug']) }}">{{ $details['base_name'] ?? $details['name'] }}</a>
                                                @endif
                                            </h3>
                                            <button class="text-neutral-400 hover:text-red-500 remove-from-cart ml-2"
                                                title="Remove">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        @if(isset($details['type']) != 'combo' && (isset($details['color']) || isset($details['size'])))
                                            <p class="text-xs text-neutral-500 mt-1">
                                                @if(isset($details['color']) && $details['color']) {{ $details['color'] }} @endif
                                                @if(isset($details['color']) && $details['color'] && isset($details['size']) && $details['size']) / @endif
                                                @if(isset($details['size']) && $details['size']) {{ $details['size'] }} @endif
                                            </p>
                                        @endif
                                        @if(isset($details['type']) && $details['type'] == 'combo')
                                            <p class="text-xs text-gold-600">Bundle Deal</p>
                                        @endif
                                        <div class="mt-1">
                                            @if(isset($details['original_price']) && $details['original_price'] > $details['price'])
                                                <span class="text-sm font-bold text-red-600">Rs. {{ number_format($details['price']) }}</span>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs text-neutral-400 line-through">Rs. {{ number_format($details['original_price']) }}</span>
                                                    <span class="text-xs font-bold text-white bg-red-600 px-1.5 py-0.5 rounded">-{{ round((($details['original_price'] - $details['price']) / $details['original_price']) * 100) }}%</span>
                                                </div>
                                            @else
                                                <span class="text-sm font-bold text-leather-900">Rs. {{ number_format($details['price']) }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-end mt-2">
                                        <!-- Quantity -->
                                        <div class="inline-flex items-center border border-neutral-300 rounded-lg h-8">
                                            <button
                                                class="px-2 h-full text-neutral-600 hover:text-leather-900 focus:outline-none update-cart flex items-center justify-center"
                                                data-action="decrease">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <input type="number" value="{{ $details['quantity'] }}"
                                                class="w-10 text-center border-none focus:ring-0 p-0 text-xs font-semibold quantity-input appearance-none m-0"
                                                min="1">
                                            <button
                                                class="px-2 h-full text-neutral-600 hover:text-leather-900 focus:outline-none update-cart flex items-center justify-center"
                                                data-action="increase">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Subtotal -->
                                        <p class="text-sm font-bold text-gold-600 subtotal">
                                            Rs. {{ number_format($details['price'] * $details['quantity']) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 flex justify-between items-center">
                        <a href="{{ route('home') }}"
                            class="flex items-center text-leather-700 font-semibold hover:text-leather-900 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Continue Shopping
                        </a>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="w-full lg:w-96 flex-shrink-0">
                    <div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
                        <h2 class="text-lg font-serif font-bold text-leather-900 mb-6 border-b border-neutral-200 pb-4">Order
                            Summary</h2>

                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-neutral-600">
                                <span>Subtotal</span>
                                <span id="cart-total">Rs. {{ number_format($total) }}</span>
                            </div>

                            <div class="flex justify-between text-neutral-600">
                                <span>Shipping</span>
                                <span id="cart-shipping">Rs. {{ number_format($shipping) }}</span>
                            </div>

                            <div class="flex justify-between text-green-600 {{ isset($discount) && $discount > 0 ? '' : 'hidden' }}" id="cart-discount-row">
                                <span>Discount</span>
                                <span id="cart-discount">- Rs. {{ isset($discount) ? number_format($discount) : '0' }}</span>
                            </div>

                            <!-- Coupon Code Section -->
                            <div class="pt-6 mt-6 border-t border-neutral-200">
                                @if(session('coupon'))
                                    <div id="coupon-applied-container" class="bg-gold-50/50 border border-gold-200 rounded-xl p-4 flex justify-between items-center relative overflow-hidden group transition-all hover:bg-gold-50">
                                        <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-br from-white/40 to-transparent transform rotate-45 translate-x-8 -translate-y-8 pointer-events-none"></div>
                                        <div class="flex items-center z-10">
                                            <div class="w-10 h-10 rounded-full bg-white border border-gold-100 flex items-center justify-center mr-3 text-gold-600 shadow-sm">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-[10px] text-gold-800 uppercase font-bold tracking-wider mb-0.5">Coupon Applied</p>
                                                <p class="font-mono font-bold text-leather-900 text-lg leading-none">{{ session('coupon.code') }}</p>
                                            </div>
                                        </div>
                                        <button type="button" id="remove-coupon-btn" class="text-neutral-400 hover:text-red-500 transition-colors p-2 rounded-lg hover:bg-white/80 z-10 focus:outline-none" title="Remove Coupon">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="hidden mt-4" id="coupon-input-container">
                                        <label for="coupon-code" class="block text-xs font-bold text-neutral-500 uppercase tracking-wider mb-2">Discount Code</label>
                                        <div class="relative flex items-center group">
                                            <input type="text" id="coupon-code" 
                                                class="w-full pl-4 pr-24 py-3 rounded-xl border border-neutral-300 focus:border-gold-500 focus:ring-4 focus:ring-gold-500/10 text-sm font-medium placeholder-neutral-400 transition-all shadow-sm uppercase" 
                                                placeholder="Enter Code">
                                            <button type="button" id="apply-coupon-btn" 
                                                class="absolute right-1.5 top-1.5 bottom-1.5 px-4 bg-leather-900 hover:bg-leather-800 text-white text-xs font-bold rounded-lg transition-all hover:shadow-md uppercase tracking-wide flex items-center justify-center disabled:opacity-70 disabled:cursor-not-allowed">
                                                Apply
                                            </button>
                                        </div>
                                        <p class="text-xs text-red-500 mt-2 font-medium hidden flex items-center gap-1" id="coupon-error">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg> 
                                            <span></span>
                                        </p>
                                    </div>
                                @else
                                    <div id="coupon-applied-container" class="hidden bg-gold-50/50 border border-gold-200 rounded-xl p-4 flex justify-between items-center relative overflow-hidden group transition-all hover:bg-gold-50">
                                        <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-br from-white/40 to-transparent transform rotate-45 translate-x-8 -translate-y-8 pointer-events-none"></div>
                                        <div class="flex items-center z-10">
                                            <div class="w-10 h-10 rounded-full bg-white border border-gold-100 flex items-center justify-center mr-3 text-gold-600 shadow-sm">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-[10px] text-gold-800 uppercase font-bold tracking-wider mb-0.5">Coupon Applied</p>
                                                <p class="font-mono font-bold text-leather-900 text-lg leading-none" id="applied-coupon-code"></p>
                                            </div>
                                        </div>
                                        <button type="button" id="remove-coupon-btn" class="text-neutral-400 hover:text-red-500 transition-colors p-2 rounded-lg hover:bg-white/80 z-10 focus:outline-none" title="Remove Coupon">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="mt-4" id="coupon-input-container">
                                        <label for="coupon-code" class="block text-xs font-bold text-neutral-500 uppercase tracking-wider mb-2">Discount Code</label>
                                        <div class="relative flex items-center group">
                                            <input type="text" id="coupon-code" 
                                                class="w-full pl-4 pr-24 py-3 rounded-xl border border-neutral-300 focus:border-gold-500 focus:ring-4 focus:ring-gold-500/10 text-sm font-medium placeholder-neutral-400 transition-all shadow-sm uppercase" 
                                                placeholder="Enter Code">
                                            <button type="button" id="apply-coupon-btn" 
                                                class="absolute right-1.5 top-1.5 bottom-1.5 px-4 bg-leather-900 hover:bg-leather-800 text-white text-xs font-bold rounded-lg transition-all hover:shadow-md uppercase tracking-wide flex items-center justify-center disabled:opacity-70 disabled:cursor-not-allowed">
                                                Apply
                                            </button>
                                        </div>
                                        <p class="text-xs text-red-500 mt-2 font-medium hidden flex items-center gap-1" id="coupon-error">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg> 
                                            <span></span>
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <div id="original-total-row" class="flex justify-between text-sm text-neutral-500 mb-2 {{ (!isset($originalTotal) || $originalTotal == $total) ? 'hidden' : '' }}">
                                <span>Original Price</span>
                                <span class="line-through" id="cart-original-total">Rs. {{ isset($originalTotal) ? number_format($originalTotal) : '' }}</span>
                            </div>
                            
                            <div id="savings-row" class="flex justify-between text-sm text-green-600 font-bold mb-4 {{ (!isset($originalTotal) || $originalTotal == $total) ? 'hidden' : '' }}">
                                <span>Your Savings</span>
                                <span id="cart-savings">Rs. {{ isset($originalTotal) ? number_format(($originalTotal - $total) + ($discount ?? 0)) : '' }}</span>
                            </div>

                            <div
                                class="flex justify-between text-lg font-bold text-leather-900 pt-4 border-t border-neutral-200">
                                <span>Total</span>
                                <span id="cart-grand-total">Rs. {{ number_format($grandTotal) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="block w-full btn-primary text-center">
                            Proceed to Checkout
                        </a>

                        <div class="mt-6 text-xs text-neutral-500 text-center">
                            <p class="mb-2">Secure Checkout</p>
                            <div class="flex justify-center space-x-2 opacity-50">
                                <svg class="h-6" viewBox="0 0 24 24" fill="currentColor"><!-- Visa icon placeholder --></svg>
                                <svg class="h-6" viewBox="0 0 24 24"
                    fill="currentColor"><!-- Mastercard icon placeholder --></svg>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Sticky Mobile Checkout Footer -->
                <div
                    class="fixed bottom-0 left-0 right-0 bg-white border-t border-neutral-200 p-4 shadow-[0_-5px_15px_rgba(0,0,0,0.05)] md:hidden z-40">
                    <div class="flex gap-4 items-center">
                        <div class="flex-1">
                            <p class="text-xs text-neutral-500 uppercase font-bold tracking-wider">Subtotal</p>
                            <p class="text-xl font-bold text-leather-900" id="mobile-cart-total">Rs.
                                {{ number_format($grandTotal) }}
                            </p>
                            <p class="text-[10px] text-neutral-400">Incl. Shipping (Rs. <span
                                    id="mobile-shipping">{{ number_format($shipping) }}</span>)</p>
                        </div>
                        <a href="{{ route('checkout.index') }}"
                            class="flex-1 btn-primary text-center py-3 text-sm rounded-xl shadow-lg">
                            Checkout
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-xl shadow-lg">
                <div class="inline-block p-6 rounded-full bg-neutral-100 text-neutral-400 mb-4">
                    <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-serif font-bold text-leather-900 mb-2">Your cart is empty</h2>
                <p class="text-neutral-600 mb-8">Looks like you haven't added any items to your cart yet.</p>
                <a href="{{ route('home') }}" class="btn-primary">Start Shopping</a>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Function to find common container (row for table, div for mobile card)
            function getCartItemContainer(element) {
                return element.closest('tr') || element.closest('.cart-item');
            }

            // Update Cart
            const updateButtons = document.querySelectorAll('.update-cart');
            updateButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const container = getCartItemContainer(this);
                    const id = container.dataset.id;
                    const input = container.querySelector('.quantity-input');
                    let quantity = parseInt(input.value);

                    if (this.dataset.action === 'increase') {
                        quantity++;
                    } else if (this.dataset.action === 'decrease' && quantity > 1) {
                        quantity--;
                    }

                    input.value = quantity;
                    updateCart(id, quantity, container);
                });
            });

            // Remove from Cart
            const removeButtons = document.querySelectorAll('.remove-from-cart');
            removeButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const container = getCartItemContainer(this);
                    const id = container.dataset.id;
                    console.log('Removing item:', id);

                    fetch('{{ route('cart.remove') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ id: id })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                container.remove();
                                updateTotals(data);

                                if (data.count === 0) {
                                    location.reload();
                                }
                            }
                        });
                });
            });

            function updateCart(id, quantity, container) {
                fetch('{{ route('cart.update') }}', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ id: id, quantity: quantity })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            container.querySelector('.subtotal').innerText = 'Rs. ' + data.subtotal;
                            updateTotals(data);
                        }
                    });
            }

            // Coupon Logic
            const applyCouponBtn = document.getElementById('apply-coupon-btn');
            
            // Re-selecting remove buttons as duplication in blade logic
            document.body.addEventListener('click', function(e) {
                const btn = e.target.closest('#remove-coupon-btn');
                if (btn) {
                    fetch('{{ route('cart.remove-coupon') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reset UI
                            document.getElementById('coupon-input-container').classList.remove('hidden');
                            document.getElementById('coupon-applied-container').classList.add('hidden');
                            document.getElementById('coupon-code').value = '';
                            const errorEl = document.getElementById('coupon-error');
                            errorEl.querySelector('span').innerText = '';
                            errorEl.classList.add('hidden');
                            
                            updateTotals(data);
                        }
                    });
                }
            });

            if(applyCouponBtn) {
                applyCouponBtn.addEventListener('click', function() {
                    const code = document.getElementById('coupon-code').value;
                    const errorEl = document.getElementById('coupon-error');
                    
                    if(!code) {
                        errorEl.querySelector('span').innerText = 'Please enter a coupon code';
                        errorEl.classList.remove('hidden');
                        return;
                    }
                    
                    fetch('{{ route('cart.apply-coupon') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ coupon_code: code })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('coupon-input-container').classList.add('hidden');
                            const appliedContainer = document.getElementById('coupon-applied-container');
                            appliedContainer.classList.remove('hidden');
                            // If first block (blade if session) is present, text is already there. If not (else), need to set it.
                            if(document.getElementById('applied-coupon-code')) {
                                document.getElementById('applied-coupon-code').innerText = code.toUpperCase();
                            } else {
                                location.reload();
                            }
                            
                            updateTotals(data);
                            errorEl.classList.add('hidden');
                        } else {
                            errorEl.querySelector('span').innerText = data.message;
                            errorEl.classList.remove('hidden');
                        }
                    });
                });
            }

            function updateTotals(data) {
                // Update all instances of total display
                if (document.getElementById('cart-total')) {
                    document.getElementById('cart-total').innerText = 'Rs. ' + data.total; 
                }
                if (document.getElementById('cart-shipping')) {
                    document.getElementById('cart-shipping').innerText = 'Rs. ' + data.shipping_cost;
                }
                
                const discountRow = document.getElementById('cart-discount-row');
                const discountVal = document.getElementById('cart-discount');
                if (data.discount && data.discount !== '0' && data.discount !== 0) {
                    if(discountRow) discountRow.classList.remove('hidden');
                    if(discountVal) discountVal.innerText = '- Rs. ' + data.discount;
                } else {
                    if(discountRow) discountRow.classList.add('hidden');
                    if(discountVal) discountVal.innerText = '- Rs. 0';
                }

                // New Original Total and Savings Logic
                const originalTotalRow = document.getElementById('original-total-row');
                const originalTotalVal = document.getElementById('cart-original-total');
                const savingsRow = document.getElementById('savings-row');
                const savingsVal = document.getElementById('cart-savings');

                if (data.original_total) {
                    const originalTotal = parseFloat(data.original_total.replace(/,/g, ''));
                    const grandTotal = parseFloat(data.grand_total.replace(/,/g, ''));
                    
                    // Only show if original total is meaningfully larger than grand total (accounting for potential float issues if any, though strings here)
                    // Logic: If user has items on sale OR applied a coupon, original total > grand total (plus shipping differences potentially)
                    // Simplest check: compare original total vs grand total. Wait, grand total includes shipping.
                    // Should compare Original Total vs (Total + Discount). 
                    // Better: Check if any difference exists between original price sum and final price sum.
                    
                    // Let's use the provided strings directly if possible, but we need numeric comparison.
                    // The blade logic was: (!isset($originalTotal) || $originalTotal == $total). $total there was subtotal.
                    // Here data.total is subtotal. data.original_total is original subtotal.
                    
                    const subtotal = parseFloat(data.total.replace(/,/g, ''));
                    
                    if (originalTotal > subtotal) {
                        if(originalTotalRow) originalTotalRow.classList.remove('hidden');
                        if(originalTotalVal) originalTotalVal.innerText = 'Rs. ' + data.original_total;
                        
                        if(savingsRow) savingsRow.classList.remove('hidden');
                        // Savings = Original Total - Grand Total? No, Savings = Original Total - Subtotal + Discount?
                        // Savings is simply Original Total - (Grand Total - Shipping) = Original Total - Subtotal + Discount?
                        // Or just Original Total - Subtotal. Wait, coupon discount is separate.
                        // Total Savings = (Original Total - Subtotal) + Coupon Discount.
                        // Or simpler: Original Total - (Grand Total - Shipping).
                        // Let's do: Savings = Original Subtotal - Final Subtotal (which is effectively what the user pays for items).
                        // Wait, data.total IS the discounted subtotal after coupon? No, check controller.
                        // Controller: total is sum of price*qty. AND we apply coupon discount separately.
                        // So data.total is "current selling price subtotal".
                        // data.original_total is "original list price subtotal".
                        // Coupon discount is subtracted from data.total to get newTotal.
                        
                        // So Total Savings = (Original Total - Subtotal) + Coupon Discount.
                        // Let's calculate from strings:
                        const discount = data.discount ? parseFloat(data.discount.replace(/,/g, '')) : 0;
                        const totalSavings = (originalTotal - subtotal) + discount;
                        
                        if(savingsVal) savingsVal.innerText = 'Rs. ' + new Intl.NumberFormat().format(totalSavings);
                    } else {
                         // Even if no product sale, if coupon is applied, we might want to show savings?
                         // If coupon discount > 0, we have savings.
                         const discount = data.discount ? parseFloat(data.discount.replace(/,/g, '')) : 0;
                         if (discount > 0) {
                             // Original total same as subtotal, but we have coupon savings.
                             // Show savings row but maybe not original price row if they are same?
                             // User asked for "Original Total" so probably yes.
                             if(originalTotalRow) originalTotalRow.classList.remove('hidden'); // Show original even if same as base subtotal, to show structure? Or maybe hide if same?
                             // If same, showing original crossed out same as current looks weird.
                             
                             // Let's stick to: Hide Original Total row if Original Total == Subtotal.
                             if(originalTotalRow) originalTotalRow.classList.add('hidden');
                             
                             // But show Savings row?
                             if(savingsRow) savingsRow.classList.remove('hidden');
                             if(savingsVal) savingsVal.innerText = 'Rs. ' + data.discount;
                         } else {
                             if(originalTotalRow) originalTotalRow.classList.add('hidden');
                             if(savingsRow) savingsRow.classList.add('hidden');
                         }
                    }
                }

                if (document.getElementById('cart-grand-total')) {
                    document.getElementById('cart-grand-total').innerText = 'Rs. ' + data.grand_total;
                }
                if (document.getElementById('mobile-cart-total')) {
                    document.getElementById('mobile-cart-total').innerText = 'Rs. ' + data.grand_total;
                }
                if (document.getElementById('mobile-shipping')) {
                    document.getElementById('mobile-shipping').innerText = data.shipping_cost;
                }
            }
        });
    </script>
@endsection