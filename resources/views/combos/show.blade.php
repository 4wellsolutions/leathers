@extends('layouts.app')

@section('meta_title', $combo->name . ' - Special Combo Deal - Leathers.pk')
@section('meta_description', Str::limit(strip_tags($combo->description), 160))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <nav class="flex text-sm text-neutral-500 mb-8">
            <a href="{{ route('home') }}" class="hover:text-gold-600 transition-colors">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('combos.index') }}" class="hover:text-gold-600 transition-colors">Combos</a>
            <span class="mx-2">/</span>
            <span class="text-leather-900 font-medium">{{ $combo->name }}</span>
        </nav>

        <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
            <!-- Combo Image/Visual -->
            <div class="flex flex-col space-y-6">
                <div class="bg-neutral-100 rounded-xl overflow-hidden p-8 border-2 border-gold-500 relative">
                    <div class="absolute top-4 left-4 bg-gold-500 text-leather-900 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                        Bundle Deal
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($combo->products->take(4) as $product)
                        <div class="aspect-w-1 aspect-h-1 bg-white rounded-lg overflow-hidden p-2">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- What's Included Section -->
                <div class="bg-white rounded-xl border border-neutral-200 p-6">
                    <h3 class="text-lg font-bold text-leather-900 mb-4">What's Included:</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4" x-data="{ selectedImage: null }">
                        @foreach($combo->products as $product)
                        @php
                            $item = $combo->items->where('product_id', $product->id)->first();
                            $qty = $item ? $item->quantity : 1;
                        @endphp
                        <div class="bg-neutral-50 rounded-lg border border-neutral-200 p-3 hover:shadow-md transition-shadow cursor-pointer" @click="selectedImage = '{{ $product->image_url }}'">
                            <div class="h-16 w-16 mx-auto">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-2">
                            </div>
                            <p class="text-xs font-medium text-leather-900 truncate">{{ $product->name }}</p>
                            <p class="text-xs text-neutral-500">Qty: {{ $qty }}</p>
                        </div>
                        @endforeach
                        
                        <!-- Image Lightbox Modal -->
                        <div x-show="selectedImage" x-cloak @click="selectedImage = null" class="fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4">
                            <div class="relative max-w-4xl w-full">
                                <button @click.stop="selectedImage = null" class="absolute -top-10 right-0 text-white hover:text-gold-400">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                <img :src="selectedImage" class="w-full h-auto rounded-lg bg-white p-8" @click.stop>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Combo Info -->
            <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                <h1 class="text-3xl font-extrabold tracking-tight text-leather-900">{{ $combo->name }}</h1>
                
                <div class="mt-3">
                    <h2 class="sr-only">Product information</h2>
                    <p class="text-3xl text-gold-600 font-bold">Rs. {{ number_format($combo->price) }}</p>
                    @php
                        $originalPrice = $combo->products->sum(function($product) use ($combo) {
                            $item = $combo->items->where('product_id', $product->id)->first();
                            return $product->price * ($item ? $item->quantity : 1);
                        });
                    @endphp
                    @if($originalPrice > $combo->price)
                    <div class="flex items-center gap-3 mt-1 flex-nowrap">
                        <span class="text-lg text-neutral-400 line-through whitespace-nowrap">Rs. {{ number_format($originalPrice) }}</span>
                        @php
                            $discount = round((($originalPrice - $combo->price) / $originalPrice) * 100);
                        @endphp
                        <span class="text-sm font-bold text-white bg-red-600 px-2 py-0.5 rounded whitespace-nowrap">-{{ $discount }}%</span>
                    </div>
                    @endif
                </div>

                <div class="mt-6">
                    <h3 class="sr-only">Description</h3>
                    <div class="text-base text-neutral-700 space-y-6">
                        <p>{{ $combo->description }}</p>
                    </div>
                </div>


                <!-- Tabs Section -->
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
                                Reviews ({{ $allReviews->count() }})
                            </button>
                        </nav>
                    </div>

                    <div class="py-8">
                        <!-- Description Tab -->
                        <div x-show="activeTab === 'description'" class="prose prose-neutral max-w-none">
                            @if($combo->description)
                                <p>{{ $combo->description }}</p>
                            @else
                                <p class="text-neutral-500 italic">No description available for this bundle.</p>
                            @endif
                        </div>

                        <!-- Reviews Tab -->
                        <div x-show="activeTab === 'reviews'" style="display: none;">
                            <div class="space-y-8">
                                @forelse($allReviews as $review)
                                <div class="border-b border-neutral-100 pb-8 last:border-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-neutral-100 rounded-full flex items-center justify-center text-leather-900 font-bold mr-3">
                                                {{ substr($review->user->name ?? 'Guest', 0, 1) }}
                                            </div>
                                            <div>
                                                <h5 class="font-bold text-leather-900">{{ $review->user->name ?? 'Guest' }}</h5>
                                                <span class="text-xs text-neutral-500">{{ $review->created_at->format('M d, Y') }} • {{ $review->product->name }}</span>
                                            </div>
                                        </div>
                                        <div class="flex text-gold-500">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                                @else
                                                    <svg class="w-4 h-4 fill-current text-neutral-300" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-neutral-600">{{ $review->comment }}</p>
                                    
                                    @if($review->image1 || $review->image2)
                                    <div class="mt-3 flex gap-2" x-data="{ lightbox: null }">
                                        @if($review->image1)
                                        <div class="w-20 h-20 rounded-md overflow-hidden border border-neutral-200 cursor-pointer hover:opacity-75 transition" @click="lightbox = '{{ $review->image1 }}'">
                                            <img src="{{ $review->image1 }}" alt="Review image" class="w-full h-full object-cover">
                                        </div>
                                        @endif
                                        @if($review->image2)
                                        <div class="w-20 h-20 rounded-md overflow-hidden border border-neutral-200 cursor-pointer hover:opacity-75 transition" @click="lightbox = '{{ $review->image2 }}'">
                                            <img src="{{ $review->image2 }}" alt="Review image" class="w-full h-full object-cover">
                                        </div>
                                        @endif
                                        
                                        <!-- Image Lightbox -->
                                        <div x-show="lightbox" x-cloak @click="lightbox = null" class="fixed inset-0 bg-black/90 z-[60] flex items-center justify-center p-4">
                                            <div class="relative max-w-5xl w-full">
                                                <button @click.stop="lightbox = null" class="absolute -top-12 right-0 text-white hover:text-gold-400 transition">
                                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                                <img :src="lightbox" class="w-full h-auto rounded-lg" @click.stop>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @empty
                                <p class="text-neutral-500 italic">No reviews yet for products in this bundle.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10">
                    <form action="{{ route('cart.add-combo', $combo->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full btn-primary flex items-center justify-center space-x-2 py-4 text-lg">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span>Add Bundle to Cart</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Related Combos -->
        @if($relatedCombos->count() > 0)
        <div class="mt-20">
            <h2 class="section-title mb-8">Other Special Bundles</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($relatedCombos as $related)
                <div class="bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-xl transition-shadow">
                    <div class="relative h-64 bg-neutral-100 p-4">
                        <div class="absolute top-4 left-4 bg-gold-500 text-leather-900 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide z-10">
                            Bundle
                        </div>
                        <div class="grid grid-cols-2 gap-2 h-full">
                            @foreach($related->products->take(4) as $product)
                            <div class="bg-white rounded-lg overflow-hidden p-2">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-leather-900 mb-2 truncate">
                            <a href="{{ route('combos.show', $related->slug) }}" class="hover:text-gold-600 transition-colors">{{ $related->name }}</a>
                        </h3>
                        <p class="text-sm text-neutral-600 mb-4 line-clamp-2">{{ $related->description }}</p>
                        <div class="flex items-baseline space-x-2 mb-4">
                            <span class="text-xl font-bold text-gold-600">Rs. {{ number_format($related->price) }}</span>
                            @php
                                $originalPrice = $related->products->sum(function($product) use ($related) {
                                    $item = $related->items->where('product_id', $product->id)->first();
                                    return $product->price * ($item ? $item->quantity : 1);
                                });
                            @endphp
                            @if($originalPrice > $related->price)
                            <span class="text-sm text-neutral-400 line-through whitespace-nowrap">Rs. {{ number_format($originalPrice) }}</span>
                            @php
                                $discount = round((($originalPrice - $related->price) / $originalPrice) * 100);
                            @endphp
                            <span class="text-xs font-bold text-white bg-red-600 px-2 py-0.5 rounded whitespace-nowrap">-{{ $discount }}%</span>
                            @endif
                        </div>
                        <a href="{{ route('combos.show', $related->slug) }}" class="block text-center btn-outline w-full">
                            View Bundle
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
@endsection
