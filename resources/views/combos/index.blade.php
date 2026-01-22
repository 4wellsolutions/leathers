@extends('layouts.app')

@section('meta_title', 'Special Bundle Deals - Leathers.pk')
@section('meta_description', 'Discover our exclusive product bundles and save more. Premium leather goods combos with special pricing.')

@section('content')
    <div class="bg-neutral-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-serif font-bold text-leather-900 mb-2">Special Bundle Deals</h1>
            <p class="text-neutral-600">Get more value with our curated product bundles and exclusive combo offers.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($combos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($combos as $combo)
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
                            <h3 class="text-lg font-bold text-leather-900 mb-2 group-hover:text-gold-600 transition-colors">
                                <a href="{{ route('combos.show', $combo->slug) }}">{{ $combo->name }}</a>
                            </h3>
                            <p class="text-sm text-neutral-600 mb-4 line-clamp-2">{{ $combo->description }}</p>

                            @php
                                $originalPrice = $combo->products->sum(function ($product) use ($combo) {
                                    $item = $combo->items->where('product_id', $product->id)->first();
                                    return $product->price * ($item ? $item->quantity : 1);
                                });
                                $savings = $originalPrice - $combo->price;
                            @endphp

                            <div class="mb-4">
                                <!-- Combo Price -->
                                <div class="flex items-center gap-3 mb-2 flex-nowrap">
                                    <span class="text-3xl font-bold text-gold-600 whitespace-nowrap">Rs.
                                        {{ number_format($combo->price) }}</span>
                                    @if($originalPrice > $combo->price)
                                        <span class="text-base text-neutral-400 line-through whitespace-nowrap">Rs.
                                            {{ number_format($originalPrice) }}</span>
                                        @php
                                            $discount = round((($originalPrice - $combo->price) / $originalPrice) * 100);
                                        @endphp
                                        <span
                                            class="text-sm font-bold text-white bg-red-600 px-2 py-0.5 rounded whitespace-nowrap">-{{ $discount }}%</span>
                                    @endif
                                </div>

                                {{-- Savings badge removed as we now show percentage --}}
                            </div>
                            <a href="{{ route('combos.show', $combo->slug) }}" class="block text-center btn-primary text-sm py-2">
                                View Bundle
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <div class="inline-block p-6 rounded-full bg-neutral-100 text-neutral-400 mb-4">
                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-leather-900 mb-2">No bundles available</h3>
                <p class="text-neutral-600 mb-6">Check back soon for exciting bundle deals.</p>
                <a href="{{ route('home') }}" class="btn-primary">Browse Products</a>
            </div>
        @endif
    </div>
@endsection