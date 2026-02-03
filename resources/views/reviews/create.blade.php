@extends('layouts.app')

@section('meta_title', 'Edit/Re-submit My Review - ' . $product->name)

@section('content')
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-md mx-auto bg-white shadow-sm overflow-hidden">
            {{-- Header --}}
            <div class="px-4 py-3 border-b border-gray-100 flex items-center">
                <a href="{{ url()->previous() }}" class="text-gray-400 mr-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-lg font-bold text-gray-800">Edit/Re-submit My Review</h1>
            </div>

            {{-- Product Card --}}
            <div class="p-4 flex items-start border-b border-gray-100 bg-white">
                <div class="w-16 h-16 border border-gray-200 rounded-md overflow-hidden flex-shrink-0 mr-3">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-gray-900 line-clamp-2 leading-tight mb-1">{{ $product->name }}
                    </h2>
                    <div class="text-xs text-gray-500">Color family:
                        {{ $product->variants->first()->color->name ?? 'Default' }}</div>
                </div>
            </div>

            <form action="{{ route('reviews.store', $product->id) }}" method="POST" enctype="multipart/form-data"
                class="p-4">
                @csrf

                {{-- Rating --}}
                <div class="mb-6 flex items-center justify-between">
                    <label class="text-sm font-bold text-gray-900">Overall Rating</label>
                    <div class="flex flex-row-reverse space-x-reverse space-x-1 group">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" name="rating" id="rating-{{ $i }}" value="{{ $i }}" class="peer sr-only"
                                required>
                            <label for="rating-{{ $i }}"
                                class="cursor-pointer text-gray-200 peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 text-2xl">★</label>
                        @endfor
                    </div>
                </div>

                {{-- Attribute Pills (Visual Only for now) --}}
                <div class="flex space-x-2 mb-4 overflow-x-auto pb-2 scrollbar-hide">
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-sm">Versatility</span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-sm">Durability</span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-sm">Ease of Cleaning</span>
                </div>

                {{-- Comment --}}
                <div class="mb-4">
                    <textarea name="comment" rows="5"
                        class="w-full bg-gray-50 border-none rounded-sm p-3 text-sm placeholder-gray-400 focus:ring-0 resize-none"
                        placeholder="What do you think of the quality and appearance?"></textarea>
                </div>

                {{-- Media Upload --}}
                <div class="mb-4">
                    <label
                        class="w-20 h-20 bg-gray-50 flex flex-col items-center justify-center border border-dashed border-gray-300 rounded-sm cursor-pointer text-gray-400 hover:bg-gray-100 transition">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-[10px] text-center leading-tight">Upload<br>Photo/Video</span>
                        <input type="file" name="media[]" multiple accept="image/*,video/*" class="hidden">
                    </label>
                </div>

                {{-- Anonymous Checkbox --}}
                <div class="mb-8 flex items-center">
                    <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1"
                        class="w-5 h-5 border-gray-300 rounded text-pink-600 focus:ring-pink-500">
                    <label for="is_anonymous" class="ml-2 text-sm text-gray-700">Anonymously</label>
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                    class="w-full bg-pink-600 text-white font-bold py-3 rounded-sm shadow-md hover:bg-pink-700 transition">
                    Submit
                </button>
            </form>
        </div>
    </div>
@endsection