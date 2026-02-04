@extends('layouts.admin')

@section('title', 'Edit Review')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-leather-900">Edit Review</h1>
            <p class="text-sm text-neutral-500">Manage review content and status</p>
        </div>
        <a href="{{ route('admin.reviews.index') }}"
            class="inline-flex items-center px-4 py-2 bg-white border border-neutral-300 rounded-lg text-sm font-medium text-neutral-700 hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Reviews
        </a>
    </div>

    <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Review Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Main Content Card -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-leather-900 mb-4">Review Details</h3>
                        
                        <!-- Review Form -->
                        <div class="space-y-6">
                            <!-- Comment -->
                            <div>
                                <label for="comment" class="block text-sm font-medium text-neutral-700 mb-1">
                                    Comment
                                </label>
                                <textarea id="comment" name="comment" rows="8"
                                    class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border-gray-300 rounded-lg"
                                    placeholder="Enter review comment...">{{ old('comment', $review->comment) }}</textarea>
                                @error('comment')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Media Section -->
                            @if($review->images || $review->video)
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 mb-3">Attached Media</label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                    @if(!empty($review->images))
                                        @foreach($review->images as $img)
                                        <div class="group relative aspect-square rounded-lg overflow-hidden border border-neutral-200 bg-neutral-100">
                                            <img src="{{ asset($img) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                            <a href="{{ asset($img) }}" target="_blank" 
                                               class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity duration-200">
                                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                        </div>
                                        @endforeach
                                    @endif
                                    
                                    @if($review->video)
                                    <div class="relative aspect-square rounded-lg overflow-hidden border border-neutral-200 bg-neutral-100 group">
                                        <div class="flex items-center justify-center w-full h-full text-neutral-400">
                                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <a href="{{ asset($review->video) }}" target="_blank" 
                                           class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity duration-200">
                                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Approval Actions -->
                <div class="flex items-center justify-end space-x-4 bg-white p-6 rounded-xl shadow-sm border border-neutral-200">
                    <a href="{{ route('admin.reviews.index') }}" class="text-sm font-medium text-neutral-500 hover:text-neutral-700">Cancel</a>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-leather-900 hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-colors">
                        Save Review
                    </button>
                </div>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="space-y-8">
                <!-- Status Card -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-neutral-500 uppercase tracking-wider mb-4">Status</h3>
                        <div class="flex items-start mb-6">
                             <div class="flex items-center h-5">
                                <input id="is_approved" name="is_approved" type="checkbox" value="1" {{ old('is_approved', $review->is_approved) ? 'checked' : '' }}
                                    class="focus:ring-gold-500 h-4 w-4 text-gold-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_approved" class="font-medium text-gray-700">Approved</label>
                                <p class="text-neutral-500">Visible on product page</p>
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-neutral-100">
                            <div class="flex justify-between items-center text-sm py-1">
                                <span class="text-neutral-500">Created</span>
                                <span class="font-medium text-neutral-900">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm py-1">
                                <span class="text-neutral-500">Rating</span>
                                <div class="flex text-gold-500">
                                    <span class="font-bold mr-1">{{ $review->rating }}</span>
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-neutral-500 uppercase tracking-wider mb-4">Product</h3>
                        <div class="flex items-start">
                            <img src="{{ $review->product->image_url }}" alt="{{ $review->product->name }}" 
                                class="w-16 h-16 rounded-lg object-cover border border-neutral-200">
                            <div class="ml-4">
                                <a href="{{ route('admin.products.edit', $review->product) }}" class="text-sm font-bold text-leather-900 hover:text-gold-600 transition-colors line-clamp-2">
                                    {{ $review->product->name }}
                                </a>
                                <p class="text-xs text-neutral-500 mt-1">{{ $review->product->category->name ?? 'Uncategorized' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Card -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-neutral-500 uppercase tracking-wider mb-4">Customer</h3>
                        <div class="flex items-center mb-4">
                            <div class="h-10 w-10 rounded-full bg-neutral-100 flex items-center justify-center text-neutral-500 font-bold border border-neutral-200">
                                {{ substr($review->user ? $review->user->name : 'G', 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $review->user ? $review->user->name : 'Guest User' }}</p>
                                <p class="text-xs text-gray-500">{{ $review->user ? $review->user->email : 'No email' }}</p>
                            </div>
                        </div>
                        @if($review->is_anonymous)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-neutral-100 text-neutral-800">
                            Posted Anonymously
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection