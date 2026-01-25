@php
    $cart = session('cart', []);
    $total = 0;
    foreach ($cart as $id => $details) {
        $total += $details['price'] * $details['quantity'];
    }
    // Shipping to be calculated at checkout
    // Don't show if empty or on cart/checkout pages
    $shouldShow = count($cart) > 0 && !request()->routeIs('cart.index') && !request()->routeIs('checkout.index');
@endphp

@if($shouldShow)
    <!-- Sticky Mobile Checkout Footer (Global) -->
    <div id="global-sticky-cart-footer"
        class="fixed bottom-0 left-0 right-0 bg-white border-t border-neutral-200 p-4 shadow-[0_-5px_15px_rgba(0,0,0,0.05)] md:hidden z-50">
        <div class="flex gap-4 items-center">
            <div class="flex-1">
                <p class="text-xs text-neutral-500 uppercase font-bold tracking-wider">Subtotal</p>
                <p class="text-xl font-bold text-leather-900" id="mobile-cart-total-global">Rs.
                    {{ number_format($total) }}
                </p>
                <p class="text-[10px] text-neutral-400">Shipping calculated at checkout</p>
            </div>
            <a href="{{ route('cart.index') }}" class="flex-1 btn-primary text-center py-3 text-sm rounded-xl shadow-lg">
                View Cart
            </a>
        </div>
    </div>
@endif