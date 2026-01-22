@extends('layouts.app')

@section('meta_title', 'My Wishlist - Leathers.pk')
@section('meta_description', 'View and manage your saved leather products')

@section('content')
    <div class="bg-neutral-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-serif font-bold text-leather-900 mb-2">My Wishlist</h1>
            <p class="text-neutral-600">Your saved products ({{ $wishlistItems->count()}} items)</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($wishlistItems->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($wishlistItems as $item)
                    <x-product-card :product="$item->product" :inWishlist="true" />
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <div class="inline-block p-6 rounded-full bg-neutral-100 text-neutral-400 mb-4">
                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-leather-900 mb-2">Your wishlist is empty</h3>
                <p class="text-neutral-600 mb-6">Start adding products you love!</p>
                <a href="{{ route('home') }}" class="btn-primary">Browse Products</a>
            </div>
        @endif
    </div>
@endsection