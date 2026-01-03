@extends('layouts.app')

@section('title', 'Internal Server Error - Leathers.pk')

@section('content')
    <div
        class="min-h-[70vh] flex items-center justify-center bg-neutral-50 px-4 sm:px-6 lg:px-8 py-12 sm:py-24 overflow-hidden relative">
        {{-- Decorative Background Elements --}}
        <div
            class="absolute top-0 left-0 w-64 h-64 bg-red-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob">
        </div>
        <div
            class="absolute top-0 right-0 w-64 h-64 bg-leather-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-8 left-20 w-64 h-64 bg-gold-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000">
        </div>

        <div class="max-w-3xl w-full text-center relative z-10">
            {{-- 500 Text Effect --}}
            <h1
                class="text-[120px] sm:text-[180px] font-black tracking-tighter text-transparent bg-clip-text bg-gradient-to-br from-red-800 to-red-600 select-none animate-fade-in-up">
                500
            </h1>

            <div class="space-y-6 animate-fade-in-up animation-delay-300">
                <h2 class="text-3xl sm:text-4xl font-bold text-neutral-900 tracking-tight">
                    A Stitch skipped?
                </h2>
                <p class="text-lg text-neutral-600 max-w-lg mx-auto">
                    Something went wrong on our servers. We're working to fix it. Please try refreshing the page or come
                    back later.
                </p>
            </div>

            {{-- Action Buttons --}}
            <div
                class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in-up animation-delay-500">
                <button onclick="window.location.reload()"
                    class="inline-flex items-center justify-center px-8 py-3 text-base font-medium text-white transition-all bg-leather-900 border border-transparent rounded-full shadow-lg hover:bg-leather-800 hover:shadow-xl hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Refresh Page
                </button>
                <a href="{{ route('home') }}"
                    class="inline-flex items-center justify-center px-8 py-3 text-base font-medium transition-all bg-white border-2 border-neutral-200 text-neutral-900 rounded-full shadow-sm hover:border-gold-500 hover:text-gold-600 hover:shadow-md hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">
                    Return Home
                </a>
            </div>
        </div>
    </div>

    {{-- Static Helpful Links (Safe from DB errors) --}}
    <div class="bg-neutral-50 border-t border-neutral-200 py-12 animate-fade-in-up animation-delay-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-xl font-bold text-leather-900 mb-6">Need Assistance?</h3>
            <div class="flex flex-wrap justify-center gap-4 sm:gap-8">
                <a href="mailto:support@leathers.pk"
                    class="text-neutral-600 hover:text-gold-600 transition-colors font-medium">Email Support</a>
                <span class="text-neutral-300 hidden sm:inline">|</span>
                <a href="{{ route('contact') }}"
                    class="text-neutral-600 hover:text-gold-600 transition-colors font-medium">Contact Us</a>
            </div>
        </div>
    </div>

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