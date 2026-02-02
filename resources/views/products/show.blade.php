@extends('layouts.app')

@section('meta_title', $product->meta_title ?? $product->name . ' - Leathers.pk')
@section('meta_description', $product->meta_description ?? Str::limit(strip_tags($product->description), 160))
@section('og_image', $product->image_url)
@section('og_type', 'product')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Breadcrumbs -->
        <nav class="flex text-sm text-neutral-500 mb-8">
            <a href="{{ route('home') }}" class="hover:text-gold-600 transition-colors">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('category.show', $product->category->slug) }}"
                class="hover:text-gold-600 transition-colors">{{ $product->category->name }}</a>
            <span class="mx-2">/</span>
            <span class="text-leather-900 font-medium">{{ $product->name }}</span>
        </nav>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-20" x-data="productSelector()">
            <!-- Product Gallery -->
            <div class="space-y-4">
                <div class="bg-neutral-100 rounded-xl overflow-hidden aspect-w-1 aspect-h-1 relative group">
                    <img id="main-image" src="{{ $product->image_url }}" alt="{{ $product->name }}"
                        class="w-full h-full object-contain p-3 transition-transform duration-500 group-hover:scale-105">
                    @if($product->sale_price)
                        <div
                            class="absolute top-4 left-4 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                            Sale
                        </div>
                    @endif
                </div>


                <!-- Thumbnails Slider -->
                <div x-show="currentGallery && currentGallery.length > 0"
                    class="flex space-x-4 overflow-x-auto pb-2 scrollbar-hide">
                    <template x-for="(img, index) in currentGallery" :key="index">
                        <button @click="updateMainImage(img)"
                            class="flex-shrink-0 w-20 h-20 bg-neutral-100 rounded-lg overflow-hidden border-2 border-transparent hover:border-gold-500 transition-all">
                            <img :src="img" class="w-full h-full object-contain p-1">
                        </button>
                    </template>
                </div>
            </div>

            <!-- Product Info -->
            <div>
                <p class="text-gold-600 font-semibold uppercase tracking-wider mb-2">{{ $product->category->name }}</p>
                <h1 class="text-4xl font-serif font-bold text-leather-900 mb-4">{{ $product->name }}</h1>

                <div class="flex items-center mb-4">
                    <div class="flex text-gold-500">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($product->average_rating))
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            @else
                                <svg class="w-5 h-5 fill-current text-neutral-300" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <span class="ml-2 text-sm text-neutral-500">({{ $product->review_count }} reviews)</span>
                </div>

                <div class="flex flex-col mb-6">
                    <span class="text-3xl font-bold text-leather-900">
                        Rs. <span id="price-value">{{ number_format($product->price) }}</span>
                    </span>
                    <div id="price-original-container" class="flex items-center gap-2 mt-1 hidden">
                        <span class="text-xl text-neutral-500 line-through">
                            Rs. <span id="original-value"></span>
                        </span>
                        <span id="price-badge" class="text-sm font-bold text-white bg-red-600 px-2 py-1 rounded"></span>
                    </div>
                </div>


                <!-- Sale Timer -->
                @if($product->sale_price && $product->sale_ends_at && $product->sale_ends_at->isFuture() && (!$product->sale_starts_at || $product->sale_starts_at->isPast()))
                    <div class="mb-6 bg-red-50 border border-red-100 rounded-lg p-4 flex items-center justify-between" x-data="{
                                                                                end: new Date('{{ $product->sale_ends_at->toIso8601String() }}').getTime(),
                                                                                now: new Date().getTime(),
                                                                                time: { days: 0, hours: 0, minutes: 0, seconds: 0 },
                                                                                timer: null,
                                                                                update() {
                                                                                    this.now = new Date().getTime();
                                                                                    const distance = this.end - this.now;
                                                                                    if (distance < 0) {
                                                                                        clearInterval(this.timer);
                                                                                        return;
                                                                                    }
                                                                                    this.time.days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                                                    this.time.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                                                    this.time.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                                                    this.time.seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                                                                },
                                                                                init() {
                                                                                    this.update();
                                                                                    this.timer = setInterval(() => this.update(), 1000);
                                                                                }
                                                                            }">
                        <div class="flex items-center text-red-600">
                            <svg class="w-5 h-5 mr-2 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-bold uppercase tracking-wide text-sm">Limited Time Offer</span>
                        </div>
                        <div class="flex space-x-2 text-center text-red-900 font-mono font-bold">
                            <div x-show="time.days > 0">
                                <span x-text="time.days"></span><span class="text-xs ml-0.5">d</span>
                            </div>
                            <div>
                                <span x-text="String(time.hours).padStart(2, '0')"></span><span class="text-xs ml-0.5">h</span>
                            </div>
                            <div>
                                <span x-text="String(time.minutes).padStart(2, '0')"></span><span
                                    class="text-xs ml-0.5">m</span>
                            </div>
                            <div>
                                <span x-text="String(time.seconds).padStart(2, '0')"></span><span
                                    class="text-xs ml-0.5">s</span>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('cart.add', $product->id) }}" method="GET" id="add-to-cart-form">
                    @csrf

                    <!-- Variants Selection -->
                    <div class="mb-8 space-y-6">

                        <!-- Colors -->
                        <template x-if="colors.length > 0">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="block font-semibold text-leather-900">Select Color: <span
                                            x-text="selectedColor ? selectedColor.name : ''"
                                            class="font-normal text-neutral-600 ml-1"></span></label>

                                    @if($product->size_guide_image)
                                        <button type="button" @click="showSizeGuide = true"
                                            class="text-sm text-gold-600 hover:text-gold-700 flex items-center font-medium transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                            </svg>
                                            Size Chart
                                        </button>
                                    @endif
                                </div>
                                <div class="flex flex-wrap gap-3">
                                    <template x-for="color in colors" :key="color.id">
                                        <button type="button" @click="selectColor(color)"
                                            :class="{'ring-2 ring-offset-2 ring-gold-500': selectedColor && selectedColor.id === color.id, 'border-neutral-200': !selectedColor || selectedColor.id !== color.id}"
                                            class="w-10 h-10 rounded-full border shadow-sm focus:outline-none transition-all relative overflow-hidden"
                                            :title="color.name">

                                            <!-- Color Swatch -->
                                            <span x-show="color.color_code" class="absolute inset-0"
                                                :style="'background-color: ' + color.color_code">
                                            </span>

                                            <!-- Image Swatch Fallback -->
                                            <img x-show="!color.color_code && color.image_url" :src="color.image_url"
                                                class="absolute inset-0 w-full h-full object-cover">
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <!-- Sizes -->
                        <template x-if="availableSizes.length > 0">
                            <div>
                                <label class="block font-semibold text-leather-900 mb-2">Select Size:</label>
                                <div class="flex flex-wrap gap-3">
                                    <template x-for="variant in availableSizes" :key="variant.id">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="variant_id" :value="variant.id"
                                                x-model="selectedVariantId" @change="updateInfo()" class="peer sr-only">
                                            <div class="px-4 py-2 border-2 border-neutral-200 rounded-lg peer-checked:border-gold-500 peer-checked:bg-gold-50 peer-checked:text-leather-900 hover:border-gold-300 transition-all text-sm font-medium"
                                                x-text="variant.size">
                                            </div>
                                        </label>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <!-- Warning if no size selected -->
                        <div x-show="colors.length > 0 && availableSizes.length > 0 && !selectedVariantId"
                            class="text-sm text-amber-600">
                            Please select a size to proceed.
                        </div>
                    </div>

                    <div class="border-t border-b border-neutral-200 py-6 mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <span class="font-semibold text-leather-900">Availability:</span>

                            <!-- Stock Status -->
                            <span x-show="currentStock > 0" class="text-green-600 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                In Stock (<span x-text="currentStock"></span>)
                            </span>
                            <span x-show="currentStock === 0" class="text-red-600 font-medium flex items-center">
                                Out of Stock
                            </span>
                        </div>

                        <div class="flex flex-col space-y-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-32">
                                    <label for="quantity" class="sr-only">Quantity</label>
                                    <div class="flex items-center border border-neutral-300 rounded-lg">
                                        <button type="button"
                                            class="px-3 py-2 text-neutral-600 hover:text-leather-900 focus:outline-none"
                                            onclick="if(document.getElementById('quantity').value > 1) document.getElementById('quantity').value--">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <input type="number" id="quantity" name="quantity" value="1" min="1"
                                            class="w-full text-center border-none focus:ring-0 p-2 text-leather-900 font-semibold">
                                        <button type="button"
                                            class="px-3 py-2 text-neutral-600 hover:text-leather-900 focus:outline-none"
                                            onclick="document.getElementById('quantity').value++">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit" name="action" value="add"
                                    :disabled="currentStock === 0 || !selectedVariantId"
                                    class="flex-grow btn-primary flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed text-white">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    <span>Add to Cart</span>
                                </button>
                            </div>
                            <button type="submit" name="action" value="buy_now"
                                :disabled="currentStock === 0 || !selectedVariantId"
                                class="w-full btn-secondary text-center disabled:opacity-50 disabled:cursor-not-allowed">
                                Buy Now
                            </button>

                            @if($product->daraz_url)
                                <a href="{{ $product->daraz_url }}" target="_blank" rel="noopener noreferrer"
                                    class="w-full flex items-center justify-center space-x-2 px-6 py-3 border-2 border-orange-500 text-orange-600 bg-white hover:bg-orange-50 rounded-lg font-bold transition-all shadow-sm hover:shadow-md">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M3 3h18v18H3V3zm16 16V5H5v14h14zM7 7h10v2H7V7zm0 4h10v2H7v-2zm0 4h7v2H7v-2z" />
                                    </svg>
                                    <span>Buy on Daraz</span>
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <svg class="w-6 h-6 text-gold-500 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <div>
                            <h4 class="font-bold text-leather-900">Premium Quality</h4>
                            <p class="text-sm text-neutral-600">Crafted from 100% genuine leather for durability and style.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <svg class="w-6 h-6 text-gold-500 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <div>
                            <h4 class="font-bold text-leather-900">Free Shipping</h4>
                            <p class="text-sm text-neutral-600">Free shipping on all orders over Rs. 5,000 across Pakistan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Tabs -->
        <div class="mt-16" x-data="{ activeTab: 'description' }">
            <div class="border-b border-neutral-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button @click="activeTab = 'description'"
                        :class="{ 'border-gold-500 text-gold-600': activeTab === 'description', 'border-transparent text-neutral-500 hover:text-neutral-700 hover:border-neutral-300': activeTab !== 'description' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm uppercase tracking-wider">
                        Description
                    </button>
                    <button @click="activeTab = 'reviews'"
                        :class="{ 'border-gold-500 text-gold-600': activeTab === 'reviews', 'border-transparent text-neutral-500 hover:text-neutral-700 hover:border-neutral-300': activeTab !== 'reviews' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm uppercase tracking-wider">
                        Reviews ({{ $product->review_count }})
                    </button>
                </nav>
            </div>

            <div class="py-8">
                <!-- Description Tab -->
                <div x-show="activeTab === 'description'" class="prose prose-neutral max-w-none">
                    <div class="prose prose-neutral max-w-none">{!! $product->description !!}</div>

                    @if($product->details)
                        <div class="mt-8">
                            {!! $product->details !!}
                        </div>
                    @endif
                </div>

                <!-- Reviews Tab -->
                <div x-show="activeTab === 'reviews'" style="display: none;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        <!-- Reviews List -->
                        <div class="space-y-8">
                            @forelse($product->reviews as $review)
                                <div class="border-b border-neutral-100 pb-8 last:border-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-neutral-100 rounded-full flex items-center justify-center text-leather-900 font-bold mr-3">
                                                {{ substr($review->user->name ?? 'Guest', 0, 1) }}
                                            </div>
                                            <div>
                                                <h5 class="font-bold text-leather-900">{{ $review->user->name ?? 'Guest' }}</h5>
                                                <span
                                                    class="text-xs text-neutral-500">{{ $review->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                        <div class="flex text-gold-500">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
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
                                    </div>
                                    <p class="text-neutral-600">{{ $review->comment }}</p>

                                    @if($review->image1 || $review->image2)
                                        <div class="mt-3 flex gap-2" x-data="{ lightbox: null }">
                                            @if($review->image1)
                                                <div class="w-20 h-20 rounded-md overflow-hidden border border-neutral-200 cursor-pointer hover:opacity-75 transition"
                                                    @click="lightbox = '{{ $review->image1 }}'">
                                                    <img src="{{ $review->image1 }}" alt="Review image"
                                                        class="w-full h-full object-cover">
                                                </div>
                                            @endif
                                            @if($review->image2)
                                                <div class="w-20 h-20 rounded-md overflow-hidden border border-neutral-200 cursor-pointer hover:opacity-75 transition"
                                                    @click="lightbox = '{{ $review->image2 }}'">
                                                    <img src="{{ $review->image2 }}" alt="Review image"
                                                        class="w-full h-full object-cover">
                                                </div>
                                            @endif

                                            <!-- Image Lightbox -->
                                            <div x-show="lightbox" x-cloak @click="lightbox = null"
                                                class="fixed inset-0 bg-black/90 z-[60] flex items-center justify-center p-4">
                                                <div class="relative max-w-5xl w-full">
                                                    <button @click.stop="lightbox = null"
                                                        class="absolute -top-12 right-0 text-white hover:text-gold-400 transition">
                                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                    <img :src="lightbox" class="w-full h-auto rounded-lg" @click.stop>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <p class="text-neutral-500 italic">No reviews yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-20">
                <h2 class="section-title mb-8">You May Also Like</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($relatedProducts as $related)
                        <x-product-card :product="$related" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('productSelector', () => ({
                colors: @json($product->colors->load('variants')->map(function ($c) {
                    $c->image_url = $c->image ? asset($c->image) : null;
                    $c->images = $c->images_urls; // Add color images
                    $c->variants->transform(function ($v) {
                        return $v;
                    });
                    return $c;
                })),
                selectedColor: null,
                selectedVariantId: null,
                availableSizes: [],
                currentStock: 0,
                currentGallery: [],

                init() {
                    // Auto-select first color if available
                    if (this.colors.length > 0) {
                        this.selectColor(this.colors[0]);
                        // Auto-select first size
                        if (this.availableSizes.length > 0) {
                            this.selectedVariantId = this.availableSizes[0].id;
                            this.updateInfo();
                        }
                    } else {
                        // No colors - check for old-style product gallery images
                        const productImages = @json($product->images_urls ?? []);
                        if (productImages && productImages.length > 0) {
                            // Old product with gallery images
                            this.currentGallery = productImages;
                        } else {
                            // Fallback to main image only
                            this.currentGallery = ['{{ $product->image_url }}'];
                        }
                        this.currentStock = {{ $product->stock ?? 0 }};
                        this.updateInfo();
                    }
                },

                selectColor(color) {
                    this.selectedColor = color;
                    this.availableSizes = color.variants || [];

                    // Auto-select first size if available
                    if (this.availableSizes.length > 0) {
                        this.selectedVariantId = this.availableSizes[0].id;
                    } else {
                        this.selectedVariantId = null;
                    }

                    // Update Gallery - show only variant images (not main image)
                    if (color.images && Array.isArray(color.images) && color.images.length > 0) {
                        // Show only color specific images in slider
                        this.currentGallery = color.images;
                        // Auto-update main image to the first image of the color
                        if (this.currentGallery.length > 0) {
                            updateMainImage(this.currentGallery[0]);
                        }
                    } else {
                        // No color images - empty slider
                        this.currentGallery = [];
                    }

                    this.updateInfo();
                },

                updateInfo() {
                    let price = {{ $product->price }}; // Default
                    let salePrice = {{ ($product->sale_price && (!$product->sale_starts_at || $product->sale_starts_at->isPast()) && (!$product->sale_ends_at || $product->sale_ends_at->isFuture())) ? $product->sale_price : 'null' }};
                    let stock = {{ $product->stock }}; // Default

                    if (this.selectedVariantId) {
                        const variant = this.availableSizes.find(v => v.id == this.selectedVariantId);
                        if (variant) {
                            stock = variant.stock;
                            price = variant.price || {{ $product->price }};
                            // Fallback to global sale price if variant doesn't have specific sale price
                            salePrice = variant.sale_price || salePrice;
                            // Note: We use 'salePrice' from the let declaration above which contains the PHP-calculated global sale price
                        }
                    }

                    this.currentStock = stock;

                    // Update Price Display
                    const priceEl = document.getElementById('price-value');
                    const originalEl = document.getElementById('original-value');
                    const originalContainer = document.getElementById('price-original-container');
                    const badgeEl = document.getElementById('price-badge');

                    if (salePrice && salePrice < price) {
                        // Show sale price
                        priceEl.innerText = new Intl.NumberFormat().format(salePrice);
                        originalEl.innerText = new Intl.NumberFormat().format(price);

                        // Calculate discount %
                        const discount = Math.round(((price - salePrice) / price) * 100);
                        badgeEl.innerText = `-${discount}%`;

                        originalContainer.classList.remove('hidden');
                    } else {
                        // Show regular price
                        priceEl.innerText = new Intl.NumberFormat().format(price);
                        originalContainer.classList.add('hidden');
                    }
                }
            }));
        });

        function updateMainImage(src) {
            document.getElementById('main-image').src = src;
        }
    </script>

    <!-- Product Schema -->
    <script type="application/ld+json">
                                                                        {
                                                                          "@@context": "https://schema.org/",
                                                                          "@@type": "Product",
                                                                          "name": "{{ $product->name }}",
                                                                          "image": [
                                                                            "{{ $product->image_url }}"
                                                                            @if($product->images_urls)
                                                                                @foreach($product->images_urls as $imageUrl)
                                                                                    ,"{{ $imageUrl }}"
                                                                                @endforeach
                                                                            @endif
                                                                           ],
                                                                          "description": "{{ $product->description }}",
                                                                          "sku": "{{ $product->id }}",
                                                                          "brand": {
                                                                            "@@type": "Brand",
                                                                            "name": "Leathers.pk"
                                                                          },
                                                                          "aggregateRating": {
                                                                            "@@type": "AggregateRating",
                                                                            "ratingValue": "{{ $product->average_rating }}",
                                                                            "reviewCount": "{{ $product->review_count }}"
                                                                          },
                                                                          "review": [
                                                                            @foreach($product->reviews as $review)
                                                                                {
                                                                                  "@@type": "Review",
                                                                                  "author": {
                                                                                    "@@type": "Person",
                                                                                    "name": "{{ $review->user->name ?? 'Guest' }}"
                                                                                  },
                                                                                  "datePublished": "{{ $review->created_at->format('Y-m-d') }}",
                                                                                  "reviewBody": "{{ $review->comment }}",
                                                                                  "reviewRating": {
                                                                                    "@@type": "Rating",
                                                                                    "ratingValue": "{{ $review->rating }}"
                                                                                  }
                                                                                }{{ !$loop->last ? ',' : '' }}
                                                                            @endforeach
                                                                          ],
                                                                          "offers": {
                                                                            "@@type": "Offer",
                                                                            "url": "{{ route('products.show', $product->slug) }}",
                                                                            "priceCurrency": "PKR",
                                                                            "price": "{{ $product->sale_price ?? $product->price }}",
                                                                            "availability": "{{ $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
                                                                            "itemCondition": "https://schema.org/NewCondition"
                                                                          }
                                                                        }
                                                                        </script>

    <!-- Breadcrumb Schema -->
    <script type="application/ld+json">
                                                                        {
                                                                          "@@context": "https://schema.org",
                                                                          "@@type": "BreadcrumbList",
                                                                          "itemListElement": [{
                                                                            "@@type": "ListItem",
                                                                            "position": 1,
                                                                            "name": "Home",
                                                                            "item": "{{ route('home') }}"
                                                                          },{
                                                                            "@@type": "ListItem",
                                                                            "position": 2,
                                                                            "name": "{{ $product->category->name }}",
                                                                            "item": "{{ route('category.show', $product->category->slug) }}"
                                                                          },{
                                                                            "@@type": "ListItem",
                                                                            "position": 3,
                                                                            "name": "{{ $product->name }}"
                                                                          }]
                                                                        }
                                                                        </script>
@endsection