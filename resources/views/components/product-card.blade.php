<div class="product-card group">
    <div class="relative aspect-square overflow-hidden bg-neutral-100 rounded-t-xl">
        <a href="{{ route('products.show', $product->slug) }}" class="block w-full h-full">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
        </a>

        @php
            // Check if product has variants
            $hasVariants = $product->variants()->count() > 0;
            $basePrice = $product->price;

            // Tier 1: Timed sale (requires dates + product base price set)
            $timedSaleActive = ($product->sale_starts_at || $product->sale_ends_at) &&
                (!$product->sale_starts_at || $product->sale_starts_at->isPast()) &&
                (!$product->sale_ends_at || $product->sale_ends_at->isFuture());
            $productHasTimedSale = $timedSaleActive && $basePrice > 0 && $product->sale_price > 0 && $product->sale_price < $basePrice;

            // Tier 2: Variant sale prices (compare sale_price vs variant's own price)
            $variantHasDiscount = false;
            $lowestVariantSalePrice = null;
            $variantBasePrice = null;
            if ($hasVariants && !$productHasTimedSale) {
                $discountVariant = $product->variants()
                    ->whereNotNull('sale_price')
                    ->where('sale_price', '>', 0)
                    ->whereRaw('sale_price < price')
                    ->orderBy('sale_price')
                    ->first();
                if ($discountVariant) {
                    $variantHasDiscount = true;
                    $lowestVariantSalePrice = $discountVariant->sale_price;
                    $variantBasePrice = $discountVariant->price;
                }
            }

            // "Sale" badge: only for timed sales
            $showSaleBadge = $productHasTimedSale;

            // Discount calculation
            $discountPercent = 0;
            if ($productHasTimedSale) {
                $discountPercent = round((($basePrice - $product->sale_price) / $basePrice) * 100);
            } elseif ($variantHasDiscount && $variantBasePrice > 0) {
                $discountPercent = round((($variantBasePrice - $lowestVariantSalePrice) / $variantBasePrice) * 100);
            }
        @endphp

        @if($showSaleBadge && $product->sale_ends_at && $product->sale_ends_at->isFuture())
            <div x-data="{
                        endTime: new Date('{{ $product->sale_ends_at->toIso8601String() }}').getTime(),
                        now: new Date().getTime(),
                        timeLeft: '',
                        update() {
                            this.now = new Date().getTime();
                            let distance = this.endTime - this.now;
                            if (distance < 0) {
                                this.timeLeft = 'Expired';
                                return;
                            }
                            let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            if (days > 0) {
                                this.timeLeft = `${days}d ${hours}h ${minutes}m`;
                            } else {
                                this.timeLeft = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                            }
                        },
                        init() {
                            this.update();
                            setInterval(() => this.update(), 1000);
                        }
                    }" class="absolute top-2 left-2 md:top-4 md:left-4 z-10">
                <div
                    class="bg-gradient-to-r from-rose-600 to-red-600 text-white text-[10px] md:text-xs font-bold px-2 py-1 md:px-3 md:py-1 rounded-full shadow-lg border border-white/20 backdrop-blur-sm flex items-center gap-1.5 animate-pulse">
                    <svg class="w-3 h-3 md:w-3.5 md:h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span x-text="timeLeft" class="font-mono tracking-tight"></span>
                </div>
            </div>
        @elseif($showSaleBadge)
            {{-- Fallback for sales without end date --}}
            <div
                class="absolute top-2 left-2 md:top-4 md:left-4 bg-emerald-600 text-white text-[10px] md:text-xs font-bold px-2 py-1 md:px-3 md:py-1.5 rounded-full uppercase tracking-wide shadow-lg animate-pulse z-10">
                Sale
            </div>
        @endif

        @if($discountPercent > 0)
            <div
                class="absolute top-2 right-2 md:top-4 md:right-4 bg-red-600 text-white text-[10px] md:text-xs font-bold px-2 py-1 md:px-3 md:py-1.5 rounded-full shadow-lg z-10">
                -{{ $discountPercent }}%
            </div>
        @endif

        @if($product->sale && $product->sale->isValid())
            <div
                class="absolute top-10 right-2 md:top-16 md:right-4 bg-gold-500 text-leather-900 text-[10px] md:text-xs font-bold px-2 py-1 md:px-3 md:py-1 rounded-full uppercase tracking-wide z-10">
                @if($product->sale->discount_type === 'percentage')
                    {{ $product->sale->discount_value }}% OFF
                @else
                    Rs. {{ number_format($product->sale->discount_value) }} OFF
                @endif
            </div>
        @endif

        <div
            class="absolute inset-x-0 bottom-0 p-4 bg-white/90 backdrop-blur-sm translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex justify-between items-center">
            @if($product->colors->count() > 0)
                <div class="flex items-center space-x-1">
                    @foreach($product->colors->take(5) as $color)
                        <div class="w-4 h-4 rounded-full border border-neutral-200 shadow-sm"
                            style="background-color: {{ $color->color_code }};" title="{{ $color->name }}"></div>
                    @endforeach
                    @if($product->colors->count() > 5)
                        <span class="text-xs text-neutral-500 font-medium">+{{ $product->colors->count() - 5 }}</span>
                    @endif
                </div>
            @elseif($product->variants->count() > 0)
                <a href="{{ route('products.show', $product->slug) }}"
                    class="text-leather-900 hover:text-gold-600 font-semibold text-sm uppercase tracking-wide">
                    Select Options
                </a>
            @else
                <a href="{{ route('cart.add', $product->id) }}"
                    class="text-leather-900 hover:text-gold-600 font-semibold text-sm uppercase tracking-wide">
                    Add to Cart
                </a>
            @endif
            <div class="flex space-x-3">
                @php
                    $inWishlist = false;
                    if (auth()->check()) {
                        $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                            ->where('product_id', $product->id)
                            ->exists();
                    } else {
                        $inWishlist = \App\Models\Wishlist::where('session_id', session()->getId())
                            ->where('product_id', $product->id)
                            ->exists();
                    }
                @endphp
                <button
                    class="wishlist-toggle text-neutral-500 hover:text-red-500 transition-colors {{ $inWishlist ? 'text-red-500' : '' }}"
                    data-product-id="{{ $product->id }}" title="Add to Wishlist">
                    <svg class="w-5 h-5" fill="{{ $inWishlist ? 'currentColor' : 'none' }}" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </button>
                <a href="{{ route('products.show', $product->slug) }}" class="text-neutral-500 hover:text-leather-900">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <!-- Card Content -->
    <div class="p-3 md:p-4 bg-white rounded-b-xl flex flex-col">
        <!-- Top Section: Category and Title -->
        <div class="flex-grow">
            <p class="text-[10px] md:text-xs text-gold-600 font-semibold uppercase tracking-wider mb-1">
                {{ $product->category->name }}
            </p>
            <h3 class="text-sm md:text-base font-bold text-leather-900 mb-2 line-clamp-2">
                <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
            </h3>
        </div>

        <!-- Bottom Section: Price and Rating -->
        <div class="mt-auto">
            <div class="flex items-center gap-1.5 md:gap-2 mb-2 flex-wrap">
                @php
                    // Tier 1: Timed sale (requires dates)
                    $timedSaleActive = ($product->sale_starts_at || $product->sale_ends_at) &&
                        (!$product->sale_starts_at || $product->sale_starts_at->isPast()) &&
                        (!$product->sale_ends_at || $product->sale_ends_at->isFuture());

                    $hasVariants = $product->variants()->count() > 0;
                    $basePrice = $product->price;
                    $lowestSalePrice = null;
                    $strikethroughPrice = $basePrice;

                    if ($hasVariants) {
                        $lowestPrice = $product->variants()->min('price');
                        $highestPrice = $product->variants()->max('price');

                        // Priority 1: Timed product-level sale
                        if ($timedSaleActive && $basePrice > 0 && $product->sale_price > 0 && $product->sale_price < $basePrice) {
                            $lowestSalePrice = $product->sale_price;
                            $strikethroughPrice = $basePrice;
                        } else {
                            // Priority 2: Variant sale prices (compare sale_price vs variant's own price)
                            $discountVariant = $product->variants()
                                ->whereNotNull('sale_price')
                                ->where('sale_price', '>', 0)
                                ->whereRaw('sale_price < price')
                                ->orderBy('sale_price')
                                ->first();
                            if ($discountVariant) {
                                $lowestSalePrice = $discountVariant->sale_price;
                                $strikethroughPrice = $discountVariant->price;
                            }
                        }
                    } else {
                        // Non-variant product: only timed sale applies
                        if ($timedSaleActive && $basePrice > 0 && $product->sale_price > 0 && $product->sale_price < $basePrice) {
                            $lowestSalePrice = $product->sale_price;
                            $strikethroughPrice = $basePrice;
                        }
                        $lowestPrice = $basePrice;
                        $highestPrice = $basePrice;
                    }

                    $displayPrice = $lowestSalePrice ?? $lowestPrice;
                    $hasDiscount = !is_null($lowestSalePrice);
                @endphp

                @if($hasDiscount)
                    <span class="text-lg md:text-2xl font-bold text-leather-900 whitespace-nowrap">Rs.
                        {{ number_format($displayPrice) }}</span>
                    <span class="text-xs md:text-base text-neutral-400 line-through whitespace-nowrap">Rs.
                        {{ number_format($strikethroughPrice) }}</span>
                @else
                    @if($hasVariants && $lowestPrice != $highestPrice)
                        <span class="text-lg md:text-2xl font-bold text-leather-900">Rs. {{ number_format($lowestPrice) }} - Rs.
                            {{ number_format($highestPrice) }}</span>
                    @else
                        <span class="text-lg md:text-2xl font-bold text-leather-900">Rs.
                            {{ number_format($displayPrice) }}</span>
                    @endif
                @endif
            </div>
            <!-- Star Rating -->
            <div class="flex items-center">
                <div class="flex text-gold-500">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($product->average_rating))
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                            </svg>
                        @else
                            <svg class="w-4 h-4 fill-current text-neutral-300" viewBox="0 0 24 24">
                                <path
                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                            </svg>
                        @endif
                    @endfor
                </div>
                <span class="ml-2 text-xs text-neutral-500">({{ $product->review_count }})</span>
            </div>
        </div>
    </div>
</div>