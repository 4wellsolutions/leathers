@extends('layouts.app')

@section('meta_title', $blog->meta_title ?? $blog->title . ' - Leathers.pk')
@section('meta_description', $blog->meta_description ?? $blog->excerpt)

@section('content')
    <!-- Post Header -->
    <div class="relative h-[60vh] min-h-[400px]">
        <img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-leather-900 via-leather-900/60 to-transparent flex items-end">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 w-full text-center">
                @if($blog->category)
                    <a href="{{ route('blog.index', ['category' => $blog->category->slug]) }}" class="inline-block bg-gold-500 text-leather-900 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-4 hover:bg-gold-400 transition-colors">
                        {{ $blog->category->name }}
                    </a>
                @endif
                <h1 class="text-3xl md:text-5xl font-serif font-bold text-white mb-6 leading-tight max-w-3xl mx-auto">{{ $blog->title }}</h1>
                <div class="flex items-center justify-center space-x-4 text-sm text-neutral-300">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $blog->published_at->format('F d, Y') }}
                    </span>
                    <span>&bull;</span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        {{ $blog->views }} Reads
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Content -->
    <article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="prose prose-lg max-w-none prose-leather prose-headings:font-serif prose-headings:text-leather-900 prose-a:text-gold-600 prose-img:rounded-xl">
            {!! $blog->content !!}
        </div>

        <!-- Tags -->
        @if($blog->tags && count($blog->tags) > 0)
            <div class="mt-12 pt-8 border-t border-neutral-200">
                <div class="flex flex-wrap gap-2 text-sm">
                    <span class="font-bold text-leather-900 mr-2">Tags:</span>
                    @foreach($blog->tags as $tag)
                        <span class="bg-neutral-100 text-neutral-600 px-3 py-1 rounded-full hover:bg-neutral-200 transition-colors cursor-pointer">#{{ trim($tag) }}</span>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Share -->
        <div class="mt-8 flex items-center justify-between">
            <span class="font-bold text-leather-900">Share this article:</span>
            <div class="flex space-x-4">
                <a href="#" class="text-neutral-500 hover:text-[#1877F2] transition-colors"><span class="sr-only">Facebook</span>FB</a>
                <a href="#" class="text-neutral-500 hover:text-[#1DA1F2] transition-colors"><span class="sr-only">Twitter</span>TW</a>
                <a href="#" class="text-neutral-500 hover:text-[#0A66C2] transition-colors"><span class="sr-only">LinkedIn</span>LI</a>
            </div>
        </div>
    </article>

    <!-- Related Articles -->
    @if($relatedBlogs->count() > 0)
    <div class="bg-neutral-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-serif font-bold text-leather-900 mb-8 text-center">You Might Also Like</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($relatedBlogs as $related)
                <a href="{{ route('blog.show', $related->slug) }}" class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow overflow-hidden group">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ $related->featured_image }}" alt="{{ $related->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-6">
                        <p class="text-xs text-gold-600 font-bold uppercase mb-2">{{ $related->created_at->format('M d, Y') }}</p>
                        <h3 class="text-lg font-bold text-leather-900 group-hover:text-gold-600 transition-colors line-clamp-2">{{ $related->title }}</h3>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif
@endsection
