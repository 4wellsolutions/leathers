@php
    $hasVariants = $product->variants()->count() > 0;

    // Check strict sale validity - at least one sale date must be set
    $saleActive = ($product->sale_starts_at || $product->sale_ends_at) &&
        (!$product->sale_starts_at || $product->sale_starts_at->isPast()) &&
        (!$product->sale_ends_at || $product->sale_ends_at->isFuture());

    $basePrice = $product->price; // Always use product base price for comparison/strikethrough

    // Default to no sale
    $salePrice = null;

    // Only calculate sale price if sale is active
    if ($saleActive) {
        // Product-level sale price takes priority (global sale)
        if ($product->sale_price > 0 && $product->sale_price < $basePrice) {
            $salePrice = $product->sale_price;
        } elseif ($hasVariants) {
            // Fallback to variant-level sale prices
            $salePrice = $product->variants()
                ->whereNotNull('sale_price')
                ->where('sale_price', '>', 0)
                ->min('sale_price');
        }
    }

    // Final check: ensure found sale price is valid and less than base
    if ($salePrice && $salePrice >= $basePrice) {
        $salePrice = null;
    }

    $hasDiscount = $salePrice && $salePrice > 0;

    $discountPercent = $hasDiscount
        ? round((($basePrice - $salePrice) / $basePrice) * 100)
        : 0;

    $displayPrice = $salePrice ?? ($hasVariants ? $product->variants()->min('price') : $basePrice);
@endphp

<div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition mb-6 group">
    <div class="flex gap-6 p-5 relative">
        <!-- Image (Balanced Size) -->
        <a href="{{ route('products.show', $product->slug) }}"
            class="w-32 h-32 lg:w-40 lg:h-40 aspect-square rounded-xl overflow-hidden bg-neutral-100 flex-shrink-0 relative">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">

            {{-- Badges --}}
            {{-- Badges --}}
            @if($hasDiscount)
                <div
                    class="absolute top-2 left-2 md:top-4 md:left-4 bg-emerald-600 text-white text-[10px] md:text-xs font-bold px-2 py-1 md:px-3 md:py-1.5 rounded-full uppercase tracking-wide">
                    Sale
                </div>
                <div
                    class="absolute top-2 right-2 md:top-4 md:right-4 bg-red-600 text-white text-[10px] md:text-xs font-bold px-2 py-1 md:px-3 md:py-1.5 rounded-full">
                    -{{ $discountPercent }}%
                </div>
            @endif
        </a>

        <!-- Content -->
        <div class="flex-1 flex flex-col justify-between">

            <!-- Top -->
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gold-600 mb-1">
                    {{ $product->category->name }}
                </p>

                <h3 class="text-lg font-bold text-leather-900 leading-snug max-w-xl mb-2">
                    <a href="{{ route('products.show', $product->slug) }}"
                        class="hover:text-gold-600 transition-colors">
                        {{ $product->name }}
                    </a>
                </h3>

                <!-- Rating -->
                <div class="flex items-center gap-2 mb-3 text-sm">
                    <div class="flex text-gold-500">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= round($product->average_rating) ? 'fill-current' : 'fill-current text-neutral-300' }}"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                            </svg>
                        @endfor
                    </div>
                    <span class="text-neutral-500">({{ $product->review_count }})</span>
                </div>

                <!-- Colors -->
                @if($product->colors->count() > 0)
                    <div class="flex items-center space-x-1 mb-2">
                        @foreach($product->colors->take(5) as $color)
                            <div class="w-4 h-4 rounded-full border border-neutral-200 shadow-sm"
                                style="background-color: {{ $color->color_code }};" title="{{ $color->name }}"></div>
                        @endforeach
                        @if($product->colors->count() > 5)
                            <span class="text-xs text-neutral-500 font-medium">+{{ $product->colors->count() - 5 }}</span>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Bottom -->
            <div class="flex items-end justify-between mt-2">

                <!-- Price -->
                <div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-xl font-bold text-leather-900">
                            Rs. {{ number_format($displayPrice) }}
                        </span>
                        @if($hasDiscount)
                            <span class="text-sm text-neutral-400 line-through">
                                Rs. {{ number_format($basePrice) }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Action -->
                @if(!$hasVariants)
                    <a href="{{ route('cart.add', $product->id) }}"
                        class="px-5 py-2.5 rounded-full text-sm font-medium bg-leather-900 text-white hover:bg-leather-800 transition-all shadow-md hover:shadow-lg">
                        Add to Cart
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>