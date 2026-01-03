@extends('layouts.app')

@section('meta_title', 'Write a Review - ' . $product->name)

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-8 sm:p-12">
                <div class="flex items-center space-x-6 mb-8">
                    <div class="w-24 h-24 bg-neutral-100 rounded-lg overflow-hidden flex-shrink-0">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                            class="w-full h-full object-contain p-2">
                    </div>
                    <div>
                        <h1 class="text-2xl font-serif font-bold text-leather-900 mb-1">Write a Review</h1>
                        <p class="text-neutral-600">for <span class="font-semibold">{{ $product->name }}</span></p>
                    </div>
                </div>

                <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                    @csrf

                    <div class="mb-8">
                        <label class="block text-sm font-bold text-leather-900 mb-4">Overall Rating</label>
                        <div class="flex flex-row-reverse justify-end space-x-reverse space-x-2 group">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" id="rating-{{ $i }}" value="{{ $i }}" class="peer sr-only"
                                    required>
                                <label for="rating-{{ $i }}"
                                    class="cursor-pointer text-neutral-300 peer-checked:text-gold-500 hover:text-gold-400 peer-hover:text-gold-400 transition-colors">
                                    <svg class="w-10 h-10 fill-current" viewBox="0 0 24 24">
                                        <path
                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                    </svg>
                                </label>
                            @endfor
                        </div>
                        @error('rating')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label for="comment" class="block text-sm font-bold text-leather-900 mb-2">Your Review</label>
                        <textarea id="comment" name="comment" rows="6"
                            class="w-full rounded-lg border-neutral-300 focus:border-gold-500 focus:ring-gold-500 placeholder-neutral-400"
                            placeholder="What did you like or dislike? What did you use this product for?"></textarea>
                        @error('comment')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('products.show', $product->slug) }}"
                            class="text-neutral-600 hover:text-leather-900 font-medium">Cancel</a>
                        <button type="submit" class="btn-primary px-8 py-3">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection