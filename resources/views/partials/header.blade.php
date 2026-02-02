<header class="w-full z-50">
    <!-- Top Bar -->
    <div class="bg-gold-500 text-leather-900 py-2 text-center text-sm font-semibold tracking-wide">
        <p>{{ \App\Models\Setting::get('topbar_text', 'FREE SHIPPING ON ALL ORDERS OVER RS. 5000') }}</p>
    </div>

    <!-- Main Navigation -->
    <nav class="bg-leather-900 text-white shadow-lg relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button type="button" class="text-gold-400 hover:text-white focus:outline-none"
                        onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- Logo -->
                <div class="flex-1 flex items-center justify-center md:justify-start md:flex-none md:w-auto">
                    <a href="{{ route('home') }}" class="flex items-center">
                        @if(\App\Models\Setting::get('site_logo'))
                            <img src="{{ asset(\App\Models\Setting::get('site_logo')) }}"
                                alt="{{ \App\Models\Setting::get('site_name', 'Leathers.pk') }}" class="h-12 md:h-14">
                        @else
                            <span class="font-serif text-2xl md:text-3xl font-bold text-gold-400 tracking-wider">
                                {{ strtoupper(\App\Models\Setting::get('site_name', 'LEATHERS')) }}<span
                                    class="text-white">.PK</span>
                            </span>
                        @endif
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ route('home') }}"
                        class="text-neutral-300 hover:text-gold-400 transition-colors duration-300 text-sm uppercase tracking-widest font-medium {{ request()->routeIs('home') ? 'text-gold-400' : '' }}">Home</a>

                    <!-- Categories Dropdown -->
                    <div class="relative group h-full flex items-center">
                        <span
                            class="text-neutral-300 hover:text-gold-400 transition-colors duration-300 text-sm uppercase tracking-widest font-medium flex items-center cursor-pointer {{ request()->routeIs('products.*') || request()->routeIs('category.*') ? 'text-gold-400' : '' }}">
                            Shop
                            <svg class="w-4 h-4 ml-1 transform group-hover:rotate-180 transition-transform duration-300"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>

                        <div
                            class="absolute left-0 top-full mt-4 w-64 bg-white rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 translate-y-4 transition-all duration-300 ease-out z-50 border border-neutral-100 overflow-hidden ring-1 ring-black ring-opacity-5">
                            <div class="py-2">
                                <div class="px-6 py-3 border-b border-neutral-100 bg-neutral-50">
                                    <span
                                        class="text-xs font-bold text-neutral-500 uppercase tracking-wider">Collections</span>
                                </div>

                                @foreach(\App\Models\Category::all() as $category)
                                    <a href="{{ route('category.show', $category->slug) }}"
                                        class="block px-6 py-3 text-sm font-medium text-leather-900 hover:bg-gold-50 hover:text-gold-700 hover:pl-8 transition-all duration-200 border-l-2 border-transparent hover:border-gold-500">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('sales.index') }}"
                        class="text-red-500 hover:text-red-400 transition-colors duration-300 text-sm uppercase tracking-widest font-bold {{ request()->routeIs('sales.index') ? 'text-red-400' : '' }}">Sale</a>

                    @if(\App\Models\Deal::where('is_active', true)->has('products')->exists())
                        <a href="{{ route('deals.index') }}"
                            class="text-neutral-300 hover:text-gold-400 transition-colors duration-300 text-sm uppercase tracking-widest font-medium {{ request()->routeIs('deals.*') ? 'text-gold-400' : '' }}">Deals</a>
                    @endif


                    <a href="{{ route('contact') }}"
                        class="text-neutral-300 hover:text-gold-400 transition-colors duration-300 text-sm uppercase tracking-widest font-medium">Contact</a>
                </div>

                <!-- Icons -->
                <div class="hidden md:flex items-center space-x-6">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="text-neutral-300 hover:text-gold-400 transition-colors flex items-center justify-center p-2"
                            title="Account">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-neutral-300 hover:text-gold-400 transition-colors flex items-center justify-center p-2"
                            title="Login">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </a>
                    @endauth

                    <a href="{{ route('home') }}" class="text-neutral-300 hover:text-gold-400 transition-colors p-2"
                        title="Search Products">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </a>
                    <div class="relative group">
                        <a href="{{ route('cart.index') }}"
                            class="text-neutral-300 hover:text-gold-400 transition-colors relative block p-2 @if(session('cart') && count(session('cart')) > 0) cart-has-items @endif">
                            <svg class="h-6 w-6 @if(session('cart') && count(session('cart')) > 0) animate-pulse @endif"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            @if(session('cart') && count(session('cart')) > 0)
                                <span
                                    class="absolute -top-1 -right-2 bg-gold-500 text-leather-900 text-[10px] font-bold rounded-full h-5 w-5 flex items-center justify-center mini-cart-count border-2 border-leather-900 animate-bounce">{{ count(session('cart')) }}</span>
                            @else
                                <span
                                    class="absolute -top-1 -right-2 bg-gold-500 text-leather-900 text-[10px] font-bold rounded-full h-5 w-5 flex items-center justify-center mini-cart-count border-2 border-leather-900">0</span>
                            @endif
                        </a>

                        <!-- Mini Cart Dropdown -->
                        <div
                            class="absolute right-0 top-full mt-2 w-[500px] bg-white rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-neutral-100 overflow-hidden transform origin-top-right ring-1 ring-black ring-opacity-5">
                            <div
                                class="px-6 py-4 bg-white border-b border-neutral-100 flex justify-between items-center">
                                <h3 class="font-serif font-bold text-xl text-leather-900">Shopping Cart</h3>
                                <span
                                    class="text-xs font-bold text-gold-600 bg-gold-50 px-3 py-1 rounded-full uppercase tracking-wider">{{ count(session('cart', [])) }}
                                    ITEMS</span>
                            </div>

                            @if(session('cart') && count(session('cart')) > 0)
                                <div class="max-h-[450px] overflow-y-auto custom-scrollbar bg-neutral-50/30">
                                    @php $total = 0 @endphp
                                    @foreach(session('cart') as $id => $details)
                                        @php $total += $details['price'] * $details['quantity'] @endphp
                                        <div id="mini-cart-item-{{ $id }}"
                                            class="p-4 border-b border-neutral-100 hover:bg-white transition-colors group/item">
                                            <div class="flex items-start gap-4 mb-3">
                                                <!-- Product Image -->
                                                <div
                                                    class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-neutral-200 bg-white shadow-sm">
                                                    @php
                                                        $imagePath = $details['image'];
                                                        if (!str_starts_with($imagePath, 'http')) {
                                                            $imagePath = asset('storage/' . $imagePath);
                                                        }
                                                    @endphp
                                                    <img src="{{ $imagePath }}" alt="{{ $details['name'] }}"
                                                        class="h-full w-full object-contain p-1">
                                                </div>

                                                <!-- Product Details -->
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex justify-between items-start gap-2">
                                                        <div>
                                                            <h4
                                                                class="text-sm font-bold text-leather-900 line-clamp-2 leading-snug">
                                                                <a href="{{ route('products.show', $details['slug'] ?? '') }}"
                                                                    class="hover:text-gold-600 transition-colors">{{ $details['base_name'] ?? $details['name'] }}</a>
                                                            </h4>
                                                            @if(isset($details['color']) || isset($details['size']))
                                                                <div class="text-xs text-neutral-500 mt-0.5 flex flex-col">
                                                                    @if(isset($details['color']))
                                                                        <span>Color: {{ $details['color'] }}</span>
                                                                    @endif
                                                                    @if(isset($details['size']))
                                                                        <span>Size: {{ $details['size'] }}</span>
                                                                    @endif
                                                                </div>
                                                            @elseif(isset($details['variant_name']))
                                                                <p class="text-xs text-neutral-500 mt-0.5">
                                                                    {{ $details['variant_name'] }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <button onclick="removeMiniCartItem('{{ $id }}', this)"
                                                            class="text-neutral-400 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-red-50 -mr-1 -mt-1"
                                                            title="Remove Item">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Qty & Price Row (Full Width) -->
                                            <div class="flex justify-between items-center bg-neutral-50 rounded px-3 py-2">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs text-neutral-500">Qty:</span>
                                                    <span
                                                        class="font-bold text-leather-900 text-sm">{{ $details['quantity'] }}</span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs text-neutral-500">Total:</span>
                                                    <span class="text-sm font-bold text-gold-600">Rs.
                                                        {{ number_format($details['price'] * $details['quantity']) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div
                                    class="p-5 bg-white border-t border-neutral-100 shadow-[0_-4px_20px_-5px_rgba(0,0,0,0.1)]">
                                    <div class="flex flex-col items-end mb-5 text-right">
                                        <p class="text-sm text-neutral-500 mb-1">Subtotal (incl. tax)</p>
                                        <p class="text-2xl font-serif font-bold text-leather-900 mb-1" id="mini-cart-total">
                                            Rs. {{ number_format($total) }}</p>
                                    </div>
                                    <div class="flex gap-3">
                                        <a href="{{ route('cart.index') }}"
                                            class="flex-1 flex justify-center items-center px-4 py-3 border border-neutral-300 rounded-lg text-sm font-bold text-leather-900 hover:bg-neutral-50 transition-all uppercase tracking-wide">
                                            View Cart
                                        </a>
                                        <a href="{{ route('checkout.index') }}"
                                            class="flex-1 flex justify-center items-center px-4 py-3 border border-transparent rounded-lg text-sm font-bold text-white bg-gold-500 hover:bg-gold-600 shadow-md hover:shadow-lg transition-all uppercase tracking-wide">
                                            Checkout
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="p-12 text-center">
                                    <div
                                        class="w-24 h-24 bg-neutral-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                        <svg class="h-12 w-12 text-neutral-300" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-serif font-bold text-leather-900 mb-2">Your cart is empty</h3>
                                    <p class="text-neutral-500 mb-8 max-w-[220px] mx-auto">Looks like you haven't added any
                                        items to your cart yet.</p>
                                    <a href="{{ route('home') }}"
                                        class="inline-flex items-center justify-center px-8 py-3 border border-transparent rounded-lg text-sm font-bold text-white bg-gold-500 hover:bg-gold-600 transition-colors uppercase tracking-wide shadow-md hover:shadow-lg">
                                        Start Shopping
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Mobile Cart Icon (Visible on mobile) -->
                <div class="flex md:hidden items-center space-x-4 relative">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-neutral-300 hover:text-gold-400 transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-neutral-300 hover:text-gold-400 transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </a>
                    @endauth

                    <div class="relative">
                        <button onclick="toggleMobileCart(event)"
                            class="text-neutral-300 hover:text-gold-400 transition-colors relative block py-2 focus:outline-none @if(session('cart') && count(session('cart')) > 0) cart-has-items @endif">
                            <svg class="h-6 w-6 @if(session('cart') && count(session('cart')) > 0) animate-pulse @endif"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            @if(session('cart') && count(session('cart')) > 0)
                                <span
                                    class="absolute -top-1 -right-2 bg-gold-500 text-leather-900 text-[10px] font-bold rounded-full h-5 w-5 flex items-center justify-center mini-cart-count border-2 border-leather-900 animate-bounce">{{ count(session('cart')) }}</span>
                            @else
                                <span
                                    class="absolute -top-1 -right-2 bg-gold-500 text-leather-900 text-[10px] font-bold rounded-full h-5 w-5 flex items-center justify-center mini-cart-count border-2 border-leather-900">0</span>
                            @endif
                        </button>

                        <!-- Mobile Mini Cart Dropdown -->
                        <div id="mobile-mini-cart"
                            class="absolute right-0 top-full mt-2 w-[300px] sm:w-[350px] bg-white rounded-xl shadow-2xl opacity-0 invisible transition-all duration-300 z-50 border border-neutral-100 overflow-hidden transform origin-top-right ring-1 ring-black ring-opacity-5">
                            <div
                                class="px-4 py-3 bg-white border-b border-neutral-100 flex justify-between items-center">
                                <h3 class="font-serif font-bold text-lg text-leather-900">Shopping Cart</h3>
                                <span
                                    class="text-xs font-bold text-gold-600 bg-gold-50 px-2 py-1 rounded-full uppercase tracking-wider">{{ count(session('cart', [])) }}
                                    ITEMS</span>
                            </div>

                            @if(session('cart') && count(session('cart')) > 0)
                                <div class="max-h-[350px] overflow-y-auto custom-scrollbar bg-neutral-50/30">
                                    @php $total = 0 @endphp
                                    @foreach(session('cart') as $id => $details)
                                        @php $total += $details['price'] * $details['quantity'] @endphp
                                        <div id="mobile-mini-cart-item-{{ $id }}"
                                            class="p-3 border-b border-neutral-100 hover:bg-white transition-colors group/item">
                                            <div class="flex items-start gap-3 mb-2">
                                                <!-- Product Image -->
                                                <div
                                                    class="h-14 w-14 flex-shrink-0 overflow-hidden rounded-md border border-neutral-200 bg-white shadow-sm">
                                                    @php
                                                        $imagePath = $details['image'];
                                                        if (!str_starts_with($imagePath, 'http')) {
                                                            $imagePath = asset('storage/' . $imagePath);
                                                        }
                                                    @endphp
                                                    <img src="{{ $imagePath }}" alt="{{ $details['name'] }}"
                                                        class="h-full w-full object-contain p-1">
                                                </div>

                                                <!-- Product Details -->
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex justify-between items-start gap-2">
                                                        <div>
                                                            <h4
                                                                class="text-sm font-bold text-leather-900 line-clamp-2 leading-snug">
                                                                <a href="{{ route('products.show', $details['slug'] ?? '') }}"
                                                                    class="hover:text-gold-600 transition-colors">{{ $details['base_name'] ?? $details['name'] }}</a>
                                                            </h4>
                                                            @if(isset($details['color']) || isset($details['size']))
                                                                <div class="text-xs text-neutral-500 mt-0.5 flex flex-col">
                                                                    @if(isset($details['color']))
                                                                        <span>Color: {{ $details['color'] }}</span>
                                                                    @endif
                                                                    @if(isset($details['size']))
                                                                        <span>Size: {{ $details['size'] }}</span>
                                                                    @endif
                                                                </div>
                                                            @elseif(isset($details['variant_name']))
                                                                <p class="text-xs text-neutral-500 mt-0.5">
                                                                    {{ $details['variant_name'] }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <button onclick="removeMiniCartItem('{{ $id }}', this)"
                                                            class="text-neutral-400 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-red-50 -mr-1 -mt-1"
                                                            title="Remove Item">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Qty & Price Row -->
                                            <div class="flex justify-between items-center bg-neutral-50 rounded px-2 py-1.5">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs text-neutral-500">Qty:</span>
                                                    <span
                                                        class="font-bold text-leather-900 text-xs">{{ $details['quantity'] }}</span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs text-neutral-500">Total:</span>
                                                    <span class="text-xs font-bold text-gold-600">Rs.
                                                        {{ number_format($details['price'] * $details['quantity']) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div
                                    class="p-4 bg-white border-t border-neutral-100 shadow-[0_-4px_20px_-5px_rgba(0,0,0,0.1)]">
                                    <div class="flex flex-col items-end mb-3 text-right">
                                        <p class="text-xs text-neutral-500 mb-0.5">Subtotal (incl. tax)</p>
                                        <p class="text-xl font-serif font-bold text-leather-900 mb-0.5"
                                            id="mini-cart-total-mobile">Rs. {{ number_format($total) }}</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('cart.index') }}"
                                            class="flex-1 flex justify-center items-center px-3 py-2.5 border border-neutral-300 rounded-lg text-xs font-bold text-leather-900 hover:bg-neutral-50 transition-all uppercase tracking-wide">
                                            View Cart
                                        </a>
                                        <a href="{{ route('checkout.index') }}"
                                            class="flex-1 flex justify-center items-center px-3 py-2.5 border border-transparent rounded-lg text-xs font-bold text-white bg-gold-500 hover:bg-gold-600 shadow-md hover:shadow-lg transition-all uppercase tracking-wide">
                                            Checkout
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="p-8 text-center">
                                    <div
                                        class="w-16 h-16 bg-neutral-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="h-8 w-8 text-neutral-300" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-serif font-bold text-leather-900 mb-1">Cart Empty</h3>
                                    <a href="{{ route('home') }}"
                                        class="mt-4 inline-flex items-center justify-center px-6 py-2 border border-transparent rounded-lg text-xs font-bold text-white bg-gold-500 hover:bg-gold-600 transition-colors uppercase tracking-wide">
                                        Shop Now
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-leather-800 border-t border-leather-700">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3" x-data="{ shopOpen: false }">
                <a href="{{ route('home') }}"
                    class="block px-3 py-2 text-base font-medium text-white hover:text-gold-400 hover:bg-leather-700 rounded-md">Home</a>

                <!-- Mobile Shop Dropdown -->
                <div class="relative">
                    <span
                        class="w-full flex items-center justify-between px-3 py-2 text-base font-medium text-white hover:text-gold-400 hover:bg-leather-700 rounded-md cursor-pointer">
                        <span>Shop</span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': shopOpen }"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>

                    <div x-show="shopOpen" x-collapse class="pl-4 mt-1 space-y-1 bg-leather-750">

                        @foreach(\App\Models\Category::all() as $category)
                            <a href="{{ route('category.show', $category->slug) }}"
                                class="block px-3 py-2 text-sm font-medium text-neutral-300 hover:text-gold-400 hover:bg-leather-700 rounded-md">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('sales.index') }}"
                    class="block px-3 py-2 text-base font-bold text-red-400 hover:text-red-300 hover:bg-leather-700 rounded-md">Sale</a>
                <a href="{{ route('deals.index') }}"
                    class="block px-3 py-2 text-base font-medium text-white hover:text-gold-400 hover:bg-leather-700 rounded-md">Deals</a>

                <a href="{{ route('contact') }}"
                    class="block px-3 py-2 text-base font-medium text-white hover:text-gold-400 hover:bg-leather-700 rounded-md">Contact</a>
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="block px-3 py-2 text-base font-medium text-white hover:text-gold-400 hover:bg-leather-700 rounded-md">My
                        Account</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-3 py-2 text-base font-medium text-white hover:text-gold-400 hover:bg-leather-700 rounded-md">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="block px-3 py-2 text-base font-medium text-white hover:text-gold-400 hover:bg-leather-700 rounded-md">Login</a>
                    <a href="{{ route('register') }}"
                        class="block px-3 py-2 text-base font-medium text-white hover:text-gold-400 hover:bg-leather-700 rounded-md">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <script>
        // Define functions globally
        window.toggleMobileCart = function (event) {
            event.preventDefault();
            const cart = document.getElementById('mobile-mini-cart');
            if (cart.classList.contains('invisible')) {
                cart.classList.remove('invisible', 'opacity-0');
                cart.classList.add('visible', 'opacity-100');
            } else {
                cart.classList.add('invisible', 'opacity-0');
                cart.classList.remove('visible', 'opacity-100');
            }
        };

        window.removeMiniCartItem = function (id, button) {
            console.log('Attempting to remove item:', id);
            // Removed confirmation dialog as per user request
            fetch('{{ route('cart.remove') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: id })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        console.log('Item removed successfully, reloading...');
                        // Reload to ensure state is consistent
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error removing item:', error);
                    alert('Failed to remove item. Please try again.');
                });
        };

        // Close mobile cart when clicking outside
        document.addEventListener('click', function (event) {
            const cart = document.getElementById('mobile-mini-cart');
            const button = event.target.closest('button');

            if (cart && !cart.classList.contains('invisible') && !cart.contains(event.target) && (!button || !button.getAttribute('onclick')?.includes('toggleMobileCart'))) {
                cart.classList.add('invisible', 'opacity-0');
                cart.classList.remove('visible', 'opacity-100');
            }
        });
    </script>
</header>