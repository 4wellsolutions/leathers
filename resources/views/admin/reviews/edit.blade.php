@extends('layouts.admin')

@section('title', 'Edit Review')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.reviews.index') }}"
                class="text-neutral-500 hover:text-leather-600 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Reviews
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
            <div class="p-6 border-b border-neutral-200 bg-neutral-50 flex justify-between items-center">
                <h1 class="text-xl font-bold text-leather-900">Edit Review</h1>
                <div class="text-sm text-neutral-500">
                    ID: {{ $review->id }}
                </div>
            </div>

            <div class="p-6">
                <!-- Product Info -->
                <div class="flex items-center p-4 bg-neutral-50 rounded-lg mb-6 border border-neutral-200">
                    <img src="{{ $review->product->image_url }}" alt="{{ $review->product->name }}"
                        class="w-16 h-16 object-cover rounded-md border border-neutral-200">
                    <div class="ml-4">
                        <h3 class="font-bold text-leather-900">{{ $review->product->name }}</h3>
                        <div class="flex items-center mt-1">
                            <span class="text-xs text-neutral-500 mr-2">Rating:</span>
                            <div class="flex text-gold-500">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-current' : 'text-neutral-300' }}"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"
                                            fill="currentColor" />
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-1 text-xs font-bold text-neutral-600">({{ $review->rating }}/5)</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- User Info (Read Only) -->
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Customer</label>
                            <input type="text" readonly
                                value="{{ $review->is_anonymous ? 'Anonymous' : ($review->user ? $review->user->name . ' (' . $review->user->email . ')' : 'Guest') }}"
                                class="block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm text-gray-500">
                        </div>

                        <!-- Comment -->
                        <div>
                            <label for="comment" class="block text-sm font-medium text-neutral-700 mb-1">Review
                                Comment</label>
                            <textarea id="comment" name="comment" rows="6"
                                class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('comment', $review->comment) }}</textarea>
                            @error('comment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" name="is_approved" value="1" {{ old('is_approved', $review->is_approved) ? 'checked' : '' }}
                                    class="h-4 w-4 text-gold-600 focus:ring-gold-500 border-gray-300 rounded">
                                <span class="text-sm font-medium text-neutral-900">Approved</span>
                            </label>
                            <p class="text-xs text-neutral-500 mt-1 ml-7">Approved reviews are visible on the product page.
                            </p>
                        </div>

                        <!-- Media Preview -->
                        @if($review->images || $review->video)
                            <div class="border-t border-neutral-200 pt-6">
                                <h4 class="text-sm font-medium text-neutral-700 mb-3">Attached Media</h4>
                                <div class="flex flex-wrap gap-4">
                                    @if(!empty($review->images))
                                        @foreach($review->images as $img)
                                            <a href="{{ asset('storage/' . $img) }}" target="_blank"
                                                class="block w-24 h-24 rounded-lg overflow-hidden border border-neutral-200 hover:border-gold-500 transition-colors relative group">
                                                <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors">
                                                </div>
                                            </a>
                                        @endforeach
                                    @endif
                                    @if($review->video)
                                        <a href="{{ asset('storage/' . $review->video) }}" target="_blank"
                                            class="flex items-center justify-center w-24 h-24 rounded-lg border border-neutral-200 bg-neutral-50 text-neutral-400 hover:text-gold-600 hover:border-gold-500 transition-colors">
                                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="pt-6 flex items-center justify-end space-x-3 border-t border-neutral-200">
                            <a href="{{ route('admin.reviews.index') }}"
                                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-leather-900 hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">
                                Update Review
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection