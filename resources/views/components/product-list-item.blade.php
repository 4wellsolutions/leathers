@php
    $hasVariants = $product->variants()->count() > 0;
    $basePrice = $product->price;

    // Tier 1: Timed sale (requires dates + product base price set)
    $timedSaleActive = ($product->sale_starts_at || $product->sale_ends_at) &&
        (!$product->sale_starts_at || $product->sale_starts_at->isPast()) &&
        (!$product->sale_ends_at || $product->sale_ends_at->isFuture());

    $salePrice = null;
    $showSaleBadge = false;
    $strikethroughPrice = $basePrice;

    // Priority 1: Timed product-level sale
    if ($timedSaleActive && $basePrice > 0 && $product->sale_price > 0 && $product->sale_price < $basePrice) {
        $salePrice = $product->sale_price;
        $showSaleBadge = true;
        $strikethroughPrice = $basePrice;
    } elseif ($hasVariants) {
        // Priority 2: Variant sale prices (compare sale_price vs variant's own price)
        $discountVariant = $product->variants()
            ->whereNotNull('sale_price')
            ->where('sale_price', '>', 0)
            ->whereRaw('sale_price < price')
            ->orderBy('sale_price')
            ->first();
        if ($discountVariant) {
            $salePrice = $discountVariant->sale_price;
            $strikethroughPrice = $discountVariant->price;
        }
    }

    $hasDiscount = !is_null($salePrice);

    $discountPercent = $hasDiscount && $strikethroughPrice > 0
        ? round((($strikethroughPrice - $salePrice) / $strikethroughPrice) * 100)
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
                <div
                    class="absolute top-2 left-2 md:top-4 md:left-4 bg-emerald-600 text-white text-[10px] md:text-xs font-bold px-2 py-1 md:px-3 md:py-1.5 rounded-full uppercase tracking-wide">
                    Sale
                </div>
            @endif
            @if($hasDiscount && $discountPercent > 0)
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
                                Rs. {{ number_format($strikethroughPrice) }}
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