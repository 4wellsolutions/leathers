@extends('layouts.app')

@section('meta_title', 'Leathers.pk - Premium Handcrafted Leather Belts, Wallets & Watches')
@section('meta_description', 'Discover the finest handcrafted leather goods in Pakistan. Shop premium leather belts, wallets, and watches with lifetime warranty and free shipping.')
@section('canonical', url('/'))

@section('content')
    <!-- Hero Section -->
    <div class="relative h-[80vh] bg-leather-900 overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('/images/hero/hero.png') }}" alt="Luxury Leather Goods"
                class="w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-transparent"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
            <div class="max-w-2xl animate-slide-up">
                <h2 class="text-gold-400 font-bold tracking-widest uppercase mb-4">Premium Leather Goods</h2>
                <h1 class="text-5xl md:text-7xl font-serif font-bold text-white mb-6 leading-tight">
                    Timeless Elegance, <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-gold-300 to-gold-600">Crafted in
                        Leather</span>
                </h1>
                <p class="text-xl text-neutral-300 mb-8 leading-relaxed max-w-lg">
                    Discover our exclusive collection of handcrafted leather belts, wallets, and watches designed for the
                    modern gentleman.
                </p>
                <div class="flex space-x-4">
                    <a href="{{ route('products.index') }}" class="btn-secondary">
                        Shop Collection
                    </a>
                    <a href="#categories" class="btn-outline border-white text-white hover:bg-white hover:text-leather-900">
                        Explore Categories
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section class="relative py-24 overflow-hidden bg-gradient-to-br from-neutral-900 via-leather-900 to-neutral-900">
        <!-- Animated background pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-gold-500 rounded-full filter blur-3xl animate-pulse"></div>
            <div
                class="absolute bottom-0 right-0 w-96 h-96 bg-gold-600 rounded-full filter blur-3xl animate-pulse delay-1000">
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-white mb-4">
                    Why Choose <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-gold-400 to-gold-600">Leathers.pk</span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-gold-400 to-gold-600 mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1: Genuine Leather -->
                <div class="group relative">
                    <!-- Diagonal background effect -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-gold-500/20 to-transparent rounded-3xl transform -skew-y-3 group-hover:skew-y-0 transition-transform duration-500">
                    </div>

                    <div
                        class="relative bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-white/20 hover:border-gold-500/50 transition-all duration-500 transform hover:-translate-y-3 hover:shadow-2xl hover:shadow-gold-500/20">
                        <!-- Animated icon container -->
                        <div class="relative mb-6">
                            <div class="w-24 h-24 mx-auto relative">
                                <!-- Rotating ring -->
                                <div class="absolute inset-0 border-4 border-gold-500/30 rounded-2xl animate-spin-slow">
                                </div>
                                <div class="absolute inset-2 border-4 border-gold-400/20 rounded-2xl animate-spin-reverse">
                                </div>

                                <!-- Icon background -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-gold-400 via-gold-500 to-gold-600 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-500">
                                    <!-- Custom leather icon -->
                                    <svg class="w-12 h-12 text-leather-900" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" />
                                        <circle cx="12" cy="12" r="3" opacity="0.3" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="text-center">
                            <h3
                                class="text-2xl font-serif font-bold text-white mb-3 group-hover:text-gold-400 transition-colors">
                                100% Genuine Leather
                            </h3>
                            <p class="text-neutral-300 leading-relaxed">
                                Sourced from the finest tanneries to ensure premium quality and durability.
                            </p>
                        </div>

                        <!-- Bottom accent -->
                        <div
                            class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-gold-500 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                    </div>
                </div>

                <!-- Feature 2: Handcrafted Excellence -->
                <div class="group relative md:mt-8">
                    <!-- Diagonal background effect -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-gold-500/20 to-transparent rounded-3xl transform skew-y-3 group-hover:skew-y-0 transition-transform duration-500">
                    </div>

                    <div
                        class="relative bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-white/20 hover:border-gold-500/50 transition-all duration-500 transform hover:-translate-y-3 hover:shadow-2xl hover:shadow-gold-500/20">
                        <!-- Animated icon container -->
                        <div class="relative mb-6">
                            <div class="w-24 h-24 mx-auto relative">
                                <!-- Rotating ring -->
                                <div class="absolute inset-0 border-4 border-gold-500/30 rounded-2xl animate-spin-slow">
                                </div>
                                <div class="absolute inset-2 border-4 border-gold-400/20 rounded-2xl animate-spin-reverse">
                                </div>

                                <!-- Icon background -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-gold-400 via-gold-500 to-gold-600 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-500">
                                    <!-- Custom craft icon -->
                                    <svg class="w-12 h-12 text-leather-900" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="text-center">
                            <h3
                                class="text-2xl font-serif font-bold text-white mb-3 group-hover:text-gold-400 transition-colors">
                                Handcrafted Excellence
                            </h3>
                            <p class="text-neutral-300 leading-relaxed">
                                Each piece is meticulously crafted by skilled artisans with attention to detail.
                            </p>
                        </div>

                        <!-- Bottom accent -->
                        <div
                            class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-gold-500 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                    </div>
                </div>

                <!-- Feature 3: Lifetime Warranty -->
                <div class="group relative">
                    <!-- Diagonal background effect -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-gold-500/20 to-transparent rounded-3xl transform -skew-y-3 group-hover:skew-y-0 transition-transform duration-500">
                    </div>

                    <div
                        class="relative bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-white/20 hover:border-gold-500/50 transition-all duration-500 transform hover:-translate-y-3 hover:shadow-2xl hover:shadow-gold-500/20">
                        <!-- Animated icon container -->
                        <div class="relative mb-6">
                            <div class="w-24 h-24 mx-auto relative">
                                <!-- Rotating ring -->
                                <div class="absolute inset-0 border-4 border-gold-500/30 rounded-2xl animate-spin-slow">
                                </div>
                                <div class="absolute inset-2 border-4 border-gold-400/20 rounded-2xl animate-spin-reverse">
                                </div>

                                <!-- Icon background -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-gold-400 via-gold-500 to-gold-600 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-500">
                                    <!-- Custom shield icon -->
                                    <svg class="w-12 h-12 text-leather-900" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="text-center">
                            <h3
                                class="text-2xl font-serif font-bold text-white mb-3 group-hover:text-gold-400 transition-colors">
                                Lifetime Warranty
                            </h3>
                            <p class="text-neutral-300 leading-relaxed">
                                We stand behind our products with a guarantee of quality that lasts a lifetime.
                            </p>
                        </div>

                        <!-- Bottom accent -->
                        <div
                            class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-gold-500 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="py-20 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="section-title">Our Collections</h2>
                <div class="w-24 h-1 bg-gold-500 mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($categories as $category)
                    <a href="{{ route('category.show', $category->slug) }}"
                        class="group relative h-96 overflow-hidden rounded-xl shadow-lg">
                        <img src="{{ $category->image }}" alt="{{ $category->name }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-80 group-hover:opacity-90 transition-opacity">
                        </div>
                        <div
                            class="absolute bottom-0 left-0 right-0 p-8 text-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                            <h3 class="text-2xl font-serif font-bold text-white mb-2">{{ $category->name }}</h3>
                            <p
                                class="text-gold-400 text-sm uppercase tracking-widest font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">
                                View Collection</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="section-title">Featured Products</h2>
                    <div class="w-24 h-1 bg-gold-500"></div>
                </div>
                <a href="{{ route('products.index') }}"
                    class="hidden md:flex items-center text-leather-700 font-semibold hover:text-leather-900 transition-colors">
                    View All Products
                    <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-12 text-center md:hidden">
                <a href="{{ route('products.index') }}" class="btn-outline inline-block">View All Products</a>
            </div>
        </div>
    </section>

    <!-- Active Deals Section -->
    @if($activeDeals && $activeDeals->products->count() > 0)
        <section class="py-20 bg-gradient-to-br from-leather-900 to-leather-800 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-cover bg-center"
                style="background-image: url('{{ asset('/images/hero/hero.png') }}');"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-serif font-bold text-white mb-2">{{ $activeDeals->name }}</h2>
                    <div class="w-24 h-1 bg-gold-500 mx-auto"></div>
                    <p class="mt-4 text-gold-400 text-lg font-semibold">
                        @if($activeDeals->discount_type === 'percentage')
                            Save {{ $activeDeals->discount_value }}% on selected items
                        @else
                            Flat Rs. {{ number_format($activeDeals->discount_value) }} off
                        @endif
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($activeDeals->products->take(4) as $product)
                        <div
                            class="bg-white rounded-xl overflow-hidden shadow-lg group hover:shadow-2xl transition-all transform hover:-translate-y-1">
                            <div class="relative h-64 overflow-hidden bg-neutral-100">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-contain p-6 transition-transform duration-500 group-hover:scale-110">
                                <div
                                    class="absolute top-4 right-4 bg-red-600 text-white text-xs font-bold px-3 py-2 rounded-full uppercase tracking-wide shadow-lg">
                                    @if($activeDeals->discount_type === 'percentage')
                                        {{ $activeDeals->discount_value }}% OFF
                                    @else
                                        Rs. {{ number_format($activeDeals->discount_value) }} OFF
                                    @endif
                                </div>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gold-600 font-semibold uppercase tracking-wider mb-1">
                                    {{ $product->category->name }}</p>
                                <h3 class="text-base font-bold text-leather-900 mb-2 truncate">
                                    <a href="{{ route('products.show', $product->slug) }}"
                                        class="hover:text-gold-600 transition-colors">{{ $product->name }}</a>
                                </h3>
                                <div class="flex items-center gap-2 mb-2 flex-nowrap">
                                    <span class="text-lg font-bold text-leather-900 whitespace-nowrap">Rs.
                                        {{ number_format($product->effective_price) }}</span>
                                    <span class="text-sm text-neutral-500 line-through whitespace-nowrap">Rs.
                                        {{ number_format($product->price) }}</span>
                                    @if($product->price > $product->effective_price)
                                                            @php
                                                                $discount = round((($product->price - $product->effective_price) / $product->price) * 100);
                                                             @endphp
                                          <span
                                                                class="text-xs font-bold text-white bg-red-600 px-2 py-0.5 rounded whitespace-nowrap">-{{ $discount }}%</span>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product->slug) }}"
                                    class="block text-center btn-primary text-sm py-2">
                                    View Deal
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 text-center">
                    <a href="{{ route('deals.index') }}" class="btn-secondary inline-block">View All Deals</a>
                </div>
            </div>
        </section>
    @endif

    <!-- Special Combos Section -->
    @if($activeCombos->count() > 0)
        <section class="py-20 bg-neutral-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="section-title">Special Bundle Deals</h2>
                    <div class="w-24 h-1 bg-gold-500 mx-auto"></div>
                    <p class="mt-4 text-neutral-600 max-w-2xl mx-auto">Get more value with our curated product bundles</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($activeCombos as $combo)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-xl transition-shadow">
                            <div class="relative h-64 bg-neutral-100 p-4">
                                <div
                                    class="absolute top-4 left-4 bg-gold-500 text-leather-900 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide z-10">
                                    Bundle Deal
                                </div>
                                <div class="grid grid-cols-2 gap-2 h-full">
                                    @foreach($combo->products->take(4) as $product)
                                        <div class="bg-white rounded-lg overflow-hidden p-2">
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                                class="w-full h-full object-contain">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-leather-900 mb-2 truncate">
                                    <a href="{{ route('combos.show', $combo->slug) }}"
                                        class="hover:text-gold-600 transition-colors">{{ $combo->name }}</a>
                                </h3>
                                <p class="text-sm text-neutral-600 mb-4 line-clamp-2">{{ $combo->description }}</p>
                                <div class="flex items-baseline space-x-2 mb-4">
                                    <span class="text-xl font-bold text-gold-600">Rs. {{ number_format($combo->price) }}</span>
                                    @php
                                        $originalPrice = $combo->products->sum(function ($product) use ($combo) {
                                            $item = $combo->items->where('product_id', $product->id)->first();
                                            return $product->price * ($item ? $item->quantity : 1);
                                        });
                                    @endphp
                                    @if($originalPrice > $combo->price)
                                        <span class="text-sm text-neutral-400 line-through">Rs.
                                            {{ number_format($originalPrice) }}</span>
                                        @php
                                            $discount = round((($originalPrice - $combo->price) / $originalPrice) * 100);
                                        @endphp
                                        <span
                                            class="text-xs font-bold text-white bg-red-600 px-2 py-0.5 rounded">-{{ $discount }}%</span>
                                    @endif
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('combos.show', $combo->slug) }}"
                                        class="flex-1 text-center btn-outline text-sm py-2">
                                        View Bundle
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 text-center">
                    <a href="{{ route('combos.index') }}" class="btn-outline inline-block">View All Bundles</a>
                </div>
            </div>
        </section>
    @endif

    <!-- Newsletter Section -->
    <section class="py-20 bg-leather-900 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-cover bg-center"
            style="background-image: url('{{ asset('/images/hero/hero.png') }}');"></div>
        <div class="relative max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-4xl font-serif font-bold text-white mb-4">Join the Inner Circle</h2>
            <p class="text-neutral-300 mb-8 text-lg">Subscribe to our newsletter for exclusive access to new collections,
                limited editions, and member-only offers.</p>
            <form class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
                <input type="email" placeholder="Your email address"
                    class="flex-grow px-6 py-4 rounded-lg bg-white/10 border border-white/20 text-white placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-gold-500 backdrop-blur-sm">
                <button type="submit" class="btn-secondary whitespace-nowrap">Subscribe Now</button>
            </form>
        </div>
    </section>
    <!-- WebSite Schema -->
    <script type="application/ld+json">
        {
          "@@context": "https://schema.org",
          "@@type": "WebSite",
          "name": "Leathers.pk",
          "url": "{{ url('/') }}",
          "potentialAction": {
            "@@type": "SearchAction",
            "target": "{{ url('/shop') }}?search={search_term_string}",
            "query-input": "required name=search_term_string"
          }
        }
        </script>
@endsection