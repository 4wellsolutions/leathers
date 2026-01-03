@php
    $hasVariants = $product->variants()->count() > 0;

    // Base & sale prices
    $basePrice = $hasVariants ? $product->variants()->min('price') : $product->price;
    $salePrice = $hasVariants
        ? $product->variants()
            ->whereNotNull('sale_price')
            ->where('sale_price', '>', 0)
            ->min('sale_price')
        : $product->sale_price;

    $hasDiscount = $salePrice && $basePrice > $salePrice;

    $discountPercent = $hasDiscount
        ? round((($basePrice - $salePrice) / $basePrice) * 100)
        : 0;

    $displayPrice = $salePrice ?? $basePrice;
@endphp

<div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition mb-6">
    <div class="flex gap-6 p-5">

        <!-- Image (Balanced Size) -->
        <a href="{{ route('products.show', $product->slug) }}"
           class="w-32 h-32 lg:w-36 lg:h-36 aspect-square rounded-xl overflow-hidden bg-neutral-100 flex-shrink-0">
            <img
                src="{{ $product->image_url }}"
                alt="{{ $product->name }}"
                class="w-full h-full object-cover"
            >
        </a>

        <!-- Content -->
        <div class="flex-1 flex flex-col justify-between">

            <!-- Top -->
            <div>
                <p class="text-xs uppercase tracking-widest text-neutral-400 mb-1">
                    {{ $product->category->name }}
                </p>

                <h3 class="text-lg font-medium text-neutral-900 leading-snug max-w-xl">
                    <a href="{{ route('products.show', $product->slug) }}"
                       class="hover:text-neutral-700 transition">
                        {{ $product->name }}
                    </a>
                </h3>

                <!-- Rating -->
                <div class="flex items-center gap-2 mt-2 text-sm text-neutral-400">
                    <div class="flex">
                        @for($i = 1; $i <= 5; $i++)
                            <svg
                                class="w-4 h-4 {{ $i <= round($product->average_rating) ? 'fill-neutral-800' : 'fill-neutral-300' }}"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        @endfor
                    </div>
                    <span>{{ $product->review_count }} reviews</span>
                </div>
            </div>

            <!-- Bottom -->
            <div class="flex items-end justify-between mt-4">

                <!-- Price -->
                <div>
                    <div class="flex items-center gap-3">
                        <span class="text-xl font-semibold text-neutral-900">
                            Rs. {{ number_format($displayPrice) }}
                        </span>

                        @if($discountPercent > 0)
                            <span class="text-sm font-medium text-emerald-700">
                                {{ $discountPercent }}% off
                            </span>
                        @endif
                    </div>

                    @if($hasDiscount)
                        <div class="text-sm text-neutral-400 line-through">
                            Rs. {{ number_format($basePrice) }}
                        </div>
                    @endif
                </div>

                <!-- Action -->
                <a href="{{ route('products.show', $product->slug) }}"
                   class="px-5 py-2.5 rounded-lg text-sm font-medium
                          bg-neutral-900 text-white hover:bg-neutral-800 transition">
                    View Product
                </a>
            </div>
        </div>
    </div>
</div>
