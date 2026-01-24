<div class="product-card group">
    <div class="relative aspect-square overflow-hidden bg-neutral-100 rounded-t-xl">
        <a href="{{ route('products.show', $product->slug) }}" class="block w-full h-full">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
        </a>

        @php
            // Check if product has any sale variants
            $hasVariants = $product->variants()->count() > 0;
            $variantHasSale = false;
            if ($hasVariants) {
                $variantHasSale = $product->variants()->whereNotNull('sale_price')->where('sale_price', '>', 0)->exists();
            }

            // Logic: 
            // 1. If variants have explicit sale, use that.
            // 2. If variants exist but NO explicit sale, check if Product has global sale (inheritance).
            // 3. If no variants, use Product sale.

            $hasSale = $variantHasSale || ($product->sale_price && $product->sale_price > 0 &&
                (!$product->sale_starts_at || $product->sale_starts_at->isPast()) &&
                (!$product->sale_ends_at || $product->sale_ends_at->isFuture()));

            // Calculate discount percentage for badge
            $discountPercent = 0;
            if ($variantHasSale) {
                $lowestSalePrice = $product->variants()->whereNotNull('sale_price')->where('sale_price', '>', 0)->min('sale_price');
                $lowestPrice = $product->variants()->min('price');
                if ($lowestSalePrice && $lowestPrice > $lowestSalePrice) {
                    $discountPercent = round((($lowestPrice - $lowestSalePrice) / $lowestPrice) * 100);
                }
            } else if ($product->sale_price && $product->price > $product->sale_price && $hasSale) {
                // Fallback to product global discount
                $discountPercent = round((($product->price - $product->sale_price) / $product->price) * 100);
            }
        @endphp

        @if($hasSale)
            <div
                class="absolute top-4 left-4 bg-emerald-600 text-white text-sm font-bold px-4 py-2 rounded-full uppercase tracking-wide shadow-lg animate-pulse">
                Sale
            </div>
        @endif

        @if($discountPercent > 0)
            <div class="absolute top-4 right-4 bg-red-600 text-white text-sm font-bold px-3 py-1.5 rounded-full shadow-lg">
                -{{ $discountPercent }}%
            </div>
        @endif

        @if($product->sale && $product->sale->isValid())
            <div
                class="absolute top-16 right-4 bg-gold-500 text-leather-900 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
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
    <div class="p-4 bg-white rounded-b-xl flex flex-col">
        <!-- Top Section: Category and Title -->
        <div class="flex-grow">
            <p class="text-xs text-gold-600 font-semibold uppercase tracking-wider mb-1">
                {{ $product->category->name }}
            </p>
            <h3 class="text-base font-bold text-leather-900 mb-2 line-clamp-2">
                <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
            </h3>
        </div>

        <!-- Bottom Section: Price and Rating -->
        <div class="mt-auto">
            <div class="flex items-center gap-2 mb-2 flex-wrap">
                @php
                    // Check if product has variants
                    $hasVariants = $product->variants()->count() > 0;

                    if ($hasVariants) {
                        // Get lowest sale price from variants, or lowest regular price
                        $lowestSalePrice = $product->variants()->whereNotNull('sale_price')->where('sale_price', '>', 0)->min('sale_price');
                        $lowestPrice = $product->variants()->min('price');
                        $highestPrice = $product->variants()->max('price');
                    } else {
                        // Use product's own prices
                        $lowestSalePrice = $product->sale_price;
                        $lowestPrice = $product->price;
                        $highestPrice = $product->price;
                    }

                    $displayPrice = $lowestSalePrice ?? $lowestPrice;
                    $hasDiscount = $lowestSalePrice && $lowestPrice > $lowestSalePrice;
                @endphp

                @if($hasDiscount)
                    <span class="text-2xl font-bold text-leather-900 whitespace-nowrap">Rs.
                        {{ number_format($displayPrice) }}</span>
                    <span class="text-base text-neutral-400 line-through whitespace-nowrap">Rs.
                        {{ number_format($lowestPrice) }}</span>
                @else
                    @if($hasVariants && $lowestPrice != $highestPrice)
                        <span class="text-2xl font-bold text-leather-900">Rs. {{ number_format($lowestPrice) }} - Rs.
                            {{ number_format($highestPrice) }}</span>
                    @else
                        <span class="text-2xl font-bold text-leather-900">Rs. {{ number_format($displayPrice) }}</span>
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