@extends('layouts.app')

@section('meta_title', 'Special Deals - Leathers.pk')
@section('meta_description', 'Shop our exclusive leather deals and save big on premium leather accessories. Best value bundles for men.')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Special Deals
                </h1>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                    Curated bundles of our premium leather accessories. Save more when you buy together.
                </p>
            </div>

            @if($deals->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($deals as $deal)
                        <div
                            class="group relative bg-white rounded-2xl shadow-sm border border-neutral-200 overflow-hidden hover:shadow-xl hover:border-gold-200 transition-all duration-300 flex flex-col h-full">
                            <!-- Bundle Badge -->
                            <div class="absolute top-3 left-3 z-10">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gold-500 text-white shadow-sm uppercase tracking-wider">
                                    Deal
                                </span>
                            </div>

                            <!-- Image Grid -->
                            <div class="bg-neutral-50 h-64 p-2 relative">
                                <div class="grid grid-cols-2 gap-1.5 h-full w-full">
                                    @foreach($deal->items->take(4) as $item)
                                        <div
                                            class="relative bg-white rounded-lg overflow-hidden border border-neutral-100 flex items-center justify-center p-2 group-hover:border-gold-100 transition-colors">
                                            @php
                                                $imgSrc = $item->product->image_url;
                                                if ($item->variant && $item->variant->image) {
                                                    $imgSrc = asset($item->variant->image);
                                                }
                                            @endphp
                                            <img src="{{ $imgSrc }}" alt="{{ $item->product->name }}"
                                                class="w-full h-full object-contain transform group-hover:scale-105 transition-transform duration-500"
                                                loading="lazy">
                                        </div>
                                    @endforeach
                                    <!-- Fallback if fewer than 4 items to keep grid structure -->
                                    @if($deal->items->count() < 4)
                                        @for($i = 0; $i < (4 - $deal->items->count()); $i++)
                                            <div class="bg-neutral-100 rounded-lg"></div>
                                        @endfor
                                    @endif
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5 flex flex-col flex-grow">
                                <h3
                                    class="text-lg font-bold text-gray-900 mb-2 line-clamp-1 group-hover:text-gold-600 transition-colors">
                                    <a href="{{ route('deals.show', $deal->slug) }}" class="focus:outline-none">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        {{ $deal->name }}
                                    </a>
                                </h3>

                                <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $deal->description }}</p>

                                <div class="mt-auto pt-4 border-t border-gray-100 relative z-10">
                                    <div class="flex items-end justify-between gap-2">
                                        <div>
                                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Deal Price</p>
                                            <div class="flex items-baseline gap-2">
                                                <span class="text-2xl font-bold text-gray-900">Rs.
                                                    {{ number_format($deal->price) }}</span>
                                            </div>
                                        </div>
                                        <div class="mb-1 text-right">
                                            @php
                                                $originalPrice = $deal->items->sum(function ($item) {
                                                    $price = $item->variant ? ($item->variant->price ?? $item->product->price) : $item->product->price;
                                                    return $price * $item->quantity;
                                                });
                                            @endphp
                                            @if($originalPrice > $deal->price)
                                                @php
                                                    $discount = round((($originalPrice - $deal->price) / $originalPrice) * 100);
                                                @endphp
                                                <span class="text-sm text-gray-400 line-through block">Rs.
                                                    {{ number_format($originalPrice) }}</span>
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-red-50 text-red-600 border border-red-100 mt-1">
                                                    Save {{ $discount }}%
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <a href="{{ route('deals.show', $deal->slug) }}"
                                        class="mt-4 w-full flex items-center justify-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-gray-900 hover:bg-gold-600 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-all duration-200">
                                        View Deal
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-24 bg-white rounded-2xl shadow-sm border border-neutral-200">
                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <h3 class="mt-4 text-xl font-medium text-gray-900">No deals available yet</h3>
                    <p class="mt-2 text-gray-500">Check back soon for exclusive deals!</p>
                </div>
            @endif
        </div>
    </div>
@endsection