@extends('layouts.app')

@section('meta_title', $deal->name . ' - Special Deal - Leathers.pk')
@section('meta_description', Str::limit(strip_tags($deal->description), 160))

@section('content')
    <div class="bg-white min-h-screen">
        <!-- Breadcrumb & Header -->
        <div class="bg-gray-50 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav class="flex text-sm text-gray-500">
                    <a href="{{ route('home') }}" class="hover:text-gold-600 transition-colors">Home</a>
                    <span class="mx-2 text-gray-300">/</span>
                    <a href="{{ route('deals.index') }}" class="hover:text-gold-600 transition-colors">Deals</a>
                    <span class="mx-2 text-gray-300">/</span>
                    <span class="text-gray-900 font-medium truncate">{{ $deal->name }}</span>
                </nav>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">
                
                <!-- Left Column: Visuals -->
                <div class="flex flex-col space-y-8">
                    <!-- Main Deal Display -->
                    <div class="bg-neutral-50 rounded-2xl p-6 border border-neutral-200 relative overflow-hidden">
                        <div class="absolute top-4 left-4 z-10">
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-gold-500 text-white shadow-sm uppercase tracking-wide">
                                Deal
                            </span>
                        </div>
                        
                        <div class="aspect-w-1 aspect-h-1 rounded-xl overflow-hidden bg-white shadow-sm border border-neutral-100 mb-6">
                            <div class="grid grid-cols-2 gap-2 h-full p-2">
                                @foreach($deal->items->take(4) as $item)
                                    <div class="relative bg-neutral-50 rounded-lg overflow-hidden flex items-center justify-center">
                                         @php
                                            $imgSrc = $item->product->image_url;
                                            if ($item->variant && $item->variant->image) {
                                                $imgSrc = asset($item->variant->image);
                                            }
                                        @endphp
                                        <img src="{{ $imgSrc }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="w-full h-full object-contain p-2">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Included Products List -->
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">What's Included in this Deal:</h3>
                            <div class="space-y-3" x-data="{ activeImage: null }">
                                @foreach($deal->items as $item)
                                    <div class="flex items-center p-3 bg-white border border-gray-100 rounded-xl shadow-sm hover:border-gold-200 transition-colors cursor-pointer group"
                                         @click="activeImage = '{{ ($item->variant && $item->variant->image) ? asset($item->variant->image) : $item->product->image_url }}'">
                                        <div class="h-14 w-14 flex-shrink-0 bg-neutral-50 rounded-lg p-1 border border-neutral-100 group-hover:border-gold-100">
                                            <img src="{{ ($item->variant && $item->variant->image) ? asset($item->variant->image) : $item->product->image_url }}" 
                                                 class="w-full h-full object-contain" alt="{{ $item->product->name }}">
                                        </div>
                                        <div class="ml-4 flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $item->product->name }}</p>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                @if($item->variant)
                                                    @if($item->variant->color)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-600">
                                                            {{ $item->variant->color->name }}
                                                        </span>
                                                    @endif
                                                    @if($item->variant->size)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-600">
                                                            {{ $item->variant->size }}
                                                        </span>
                                                    @endif
                                                @endif
                                                <span class="text-xs text-gray-400">Qty: {{ $item->quantity }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-2 text-gray-400 group-hover:text-gold-500">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Lightbox -->
                                <div x-show="activeImage" x-cloak 
                                     class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-sm p-4"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0">
                                    <div class="relative max-w-5xl w-full max-h-[90vh]" @click.away="activeImage = null">
                                        <button @click="activeImage = null" class="absolute -top-12 right-0 text-white hover:text-gold-400 focus:outline-none p-2 rounded-full hover:bg-white/10 transition">
                                            <span class="sr-only">Close</span>
                                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                        <img :src="activeImage" class="w-full h-full object-contain rounded-lg shadow-2xl bg-white" alt="Zoomed Image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Details & Actions -->
                <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                    <div class="sticky top-24">
                        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl mb-4">{{ $deal->name }}</h1>
                        
                        <div class="flex items-center gap-4 mb-6">
                            @php
                                $originalPrice = $deal->items->sum(function($item) {
                                    $price = $item->variant ? ($item->variant->price ?? $item->product->price) : $item->product->price;
                                    return $price * $item->quantity;
                                });
                            @endphp
                            
                            <h2 class="sr-only">Product Information</h2>
                            <p class="text-4xl font-black text-gray-900">Rs. {{ number_format($deal->price) }}</p>
                            
                            @if($originalPrice > $deal->price)
                                <div class="flex flex-col items-start">
                                    <span class="text-lg text-gray-400 line-through">Rs. {{ number_format($originalPrice) }}</span>
                                    @php $discount = round((($originalPrice - $deal->price) / $originalPrice) * 100); @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-800">
                                        Save {{ $discount }}%
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="prose prose-sm prose-neutral text-gray-500 mb-8">
                            <p>{{ $deal->description }}</p>
                        </div>

                        <form action="{{ route('cart.add-deal', $deal->id) }}" method="POST" class="mt-8">
                            @csrf
                            <button type="submit" 
                                class="w-full flex items-center justify-center px-8 py-4 border border-transparent rounded-xl shadow-lg text-lg font-bold text-white bg-gray-900 hover:bg-gold-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-all duration-300 transform hover:-translate-y-1">
                                <svg class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                Add Deal to Cart
                            </button>
                            <p class="mt-3 text-center text-xs text-gray-400">
                                <svg class="w-4 h-4 inline-block mr-1 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Safe & Secure Checkout
                            </p>
                        </form>

                        <!-- Additional Info Tabs (Simplified) -->
                         <div class="mt-12 border-t border-gray-100 pt-8" x-data="{ activeTab: 'description' }">
                            <div class="flex space-x-6 border-b border-gray-200 mb-6">
                                <button @click="activeTab = 'description'" 
                                    :class="{ 'border-gold-500 text-gold-600': activeTab === 'description', 'border-transparent text-gray-400 hover:text-gray-600': activeTab !== 'description' }"
                                    class="pb-3 text-sm font-semibold uppercase tracking-wide border-b-2 transition-colors">
                                    Description
                                </button>
                                <button @click="activeTab = 'reviews'" 
                                    :class="{ 'border-gold-500 text-gold-600': activeTab === 'reviews', 'border-transparent text-gray-400 hover:text-gray-600': activeTab !== 'reviews' }"
                                    class="pb-3 text-sm font-semibold uppercase tracking-wide border-b-2 transition-colors">
                                    Reviews ({{ $allReviews->count() }})
                                </button>
                            </div>

                            <div x-show="activeTab === 'description'" class="text-gray-600 leading-relaxed text-sm">
                                @if($deal->description)
                                    <p>{{ $deal->description }}</p>
                                @else
                                    <p class="italic text-gray-400">No additional description available.</p>
                                @endif
                            </div>

                            <div x-show="activeTab === 'reviews'" style="display: none;">
                                @if($allReviews->count() > 0)
                                    <div class="space-y-6">
                                        @foreach($allReviews as $review)
                                            <div class="border-b border-gray-100 pb-6 last:border-0">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div class="flex items-center">
                                                        <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-600 mr-3">
                                                            {{ substr($review->user->name ?? 'G', 0, 1) }}
                                                        </div>
                                                        <span class="text-sm font-bold text-gray-900">{{ $review->user->name ?? 'Guest' }}</span>
                                                    </div>
                                                    <div class="flex text-gold-400">
                                                        @for($i=0; $i<5; $i++)
                                                            <svg class="w-3 h-3 {{ $i < $review->rating ? 'fill-current' : 'text-gray-200 fill-current' }}" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <p class="text-sm text-gray-600">{{ $review->comment }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-400 italic text-sm">No reviews yet for these products.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Bundles -->
            @if($relatedDeals->count() > 0)
                <div class="mt-20 border-t border-gray-100 pt-16">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">You Might Also Like</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedDeals as $related)
                            <a href="{{ route('deals.show', $related->slug) }}" class="group block">
                                <div class="bg-gray-100 rounded-xl overflow-hidden aspect-w-4 aspect-h-3 mb-4">
                                     <div class="grid grid-cols-2 gap-1 p-2 h-full">
                                        @foreach($related->items->take(4) as $item)
                                            <div class="bg-white rounded overflow-hidden flex items-center justify-center">
                                                 <img src="{{ ($item->variant && $item->variant->image) ? asset($item->variant->image) : $item->product->image_url }}" class="w-full h-full object-contain p-1">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <h3 class="text-sm font-bold text-gray-900 group-hover:text-gold-600 transition truncate">{{ $related->name }}</h3>
                                <p class="text-sm text-gray-500 mt-1">Rs. {{ number_format($related->price) }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
