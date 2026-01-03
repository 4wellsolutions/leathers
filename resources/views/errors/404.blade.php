@extends('layouts.app')

@section('title', 'Page Not Found - Leathers.pk')

@section('content')
    @php
        $suggestedProducts = \App\Models\Product::where('is_active', true)
            ->with('category')
            ->inRandomOrder()
            ->take(4)
            ->get();

        $categories = \App\Models\Category::has('products')
            ->take(6)
            ->get();
    @endphp

    <div
        class="min-h-[60vh] flex items-center justify-center bg-neutral-50 px-4 sm:px-6 lg:px-8 py-12 sm:py-24 overflow-hidden relative">
        {{-- Decorative Background Elements --}}
        <div
            class="absolute top-0 left-0 w-64 h-64 bg-gold-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob">
        </div>
        <div
            class="absolute top-0 right-0 w-64 h-64 bg-leather-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-8 left-20 w-64 h-64 bg-neutral-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000">
        </div>

        <div class="max-w-3xl w-full text-center relative z-10">
            {{-- 404 Text Effect --}}
            <h1
                class="text-[120px] sm:text-[180px] font-black tracking-tighter text-transparent bg-clip-text bg-gradient-to-br from-leather-800 to-leather-600 select-none animate-fade-in-up">
                404
            </h1>

            <div class="space-y-6 animate-fade-in-up animation-delay-300">
                <h2 class="text-3xl sm:text-4xl font-bold text-neutral-900 tracking-tight">
                    Lost in the Grain?
                </h2>
                <p class="text-lg text-neutral-600 max-w-lg mx-auto">
                    The page you're looking for seems to have slipped through the cracks. It might have been moved, deleted,
                    or never existed.
                </p>
            </div>

            {{-- Search Bar --}}
            <div class="mt-8 max-w-md mx-auto animate-fade-in-up animation-delay-500">
                <form action="{{ route('products.index') }}" method="GET" class="relative group">
                    <input type="text" name="search" placeholder="Search specifically for..."
                        class="w-full px-5 py-3 pr-12 text-neutral-900 bg-white border-2 border-neutral-200 rounded-full focus:border-gold-500 focus:ring-0 focus:outline-none transition-all shadow-sm group-hover:border-neutral-300">
                    <button type="submit"
                        class="absolute right-4 inset-y-0 flex items-center p-2 text-neutral-400 hover:text-gold-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            {{-- Action Buttons --}}
            <div
                class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in-up animation-delay-700">
                <a href="{{ route('home') }}"
                    class="inline-flex items-center justify-center px-8 py-3 text-base font-medium text-white transition-all bg-leather-900 border border-transparent rounded-full shadow-lg hover:bg-leather-800 hover:shadow-xl hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Return Home
                </a>
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center justify-center px-8 py-3 text-base font-medium transition-all bg-white border-2 border-neutral-200 text-neutral-900 rounded-full shadow-sm hover:border-gold-500 hover:text-gold-600 hover:shadow-md hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">
                    Browse Collections
                </a>
            </div>
        </div>
    </div>

    @if($suggestedProducts->count() > 0)
        <div class="bg-neutral-50 border-t border-neutral-200 py-16 animate-fade-in-up animation-delay-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h3 class="text-3xl font-black text-leather-900 mb-8 text-center tracking-tight">You Might Like</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($suggestedProducts as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if($categories->count() > 0)
        <div class="bg-neutral-50 border-t border-neutral-200 py-12 animate-fade-in-up animation-delay-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h3 class="text-xl font-bold text-leather-900 mb-6">Popular Categories</h3>
                <div class="flex flex-wrap justify-center gap-3">
                    @foreach($categories as $category)
                        <a href="{{ route('category.show', $category->slug) }}"
                            class="inline-flex items-center px-4 py-2 rounded-full border border-neutral-200 bg-white text-sm font-medium text-neutral-700 hover:bg-gold-50 hover:border-gold-300 hover:text-gold-700 transition-colors shadow-sm">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animation-delay-300 {
            animation-delay: 0.3s;
        }

        .animation-delay-500 {
            animation-delay: 0.5s;
        }

        .animation-delay-700 {
            animation-delay: 0.7s;
        }
    </style>
@endsection