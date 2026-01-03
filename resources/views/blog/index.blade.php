@extends('layouts.app')

@section('meta_title', 'Blog - Leathers.pk')
@section('meta_description', 'Read our latest articles about leather care, fashion tips, and more.')

@section('content')
    <!-- Hero Section -->
    <div class="bg-leather-900 py-16 text-center">
        <h1 class="text-4xl md:text-5xl font-serif font-bold text-gold-500 mb-4">The Journal</h1>
        <p class="text-neutral-300 max-w-2xl mx-auto px-4">Insights, stories, and guides from the world of premium leather.</p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if($blogs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($blogs as $blog)
                <article class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-xl transition-all duration-300 border border-neutral-100">
                    <a href="{{ route('blog.show', $blog->slug) }}" class="block overflow-hidden h-56 relative">
                        <img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition-colors"></div>
                    </a>
                    <div class="p-6">
                        <div class="flex items-center text-xs text-gold-600 font-semibold uppercase tracking-wider mb-2 gap-2">
                            @if($blog->category)
                                <span>{{ $blog->category->name }}</span>
                                <span class="text-neutral-300">&bull;</span>
                            @endif
                            <span>{{ $blog->published_at->format('M d, Y') }}</span>
                        </div>
                        <h2 class="text-xl font-bold text-leather-900 mb-3 line-clamp-2 group-hover:text-gold-600 transition-colors">
                            <a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                        </h2>
                        <p class="text-neutral-600 text-sm mb-4 line-clamp-3 leading-relaxed">
                            {{ $blog->excerpt }}
                        </p>
                        <a href="{{ route('blog.show', $blog->slug) }}" class="inline-flex items-center text-sm font-bold text-leather-900 hover:text-gold-600 transition-colors group/link">
                            Read Article
                            <svg class="w-4 h-4 ml-1 transform group-hover/link:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $blogs->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-neutral-50 rounded-xl border border-neutral-200">
                <div class="inline-block p-4 rounded-full bg-white text-neutral-400 mb-4 shadow-sm">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <h3 class="text-xl font-serif font-bold text-leather-900 mb-2">No Articles Found</h3>
                <p class="text-neutral-600">Check back soon for our latest updates and stories.</p>
            </div>
        @endif
    </div>
@endsection
