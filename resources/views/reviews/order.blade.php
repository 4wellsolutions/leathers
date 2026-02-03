@extends('layouts.app')

@section('meta_title', 'Review Your Order #' . $order->order_number)

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8 text-center sm:text-left">
            <h1 class="text-3xl font-serif font-bold text-leather-900 mb-2">Review Your Order</h1>
            <p class="text-neutral-600">Order #{{ $order->order_number }} &bull; {{ $order->created_at->format('F d, Y') }}
            </p>
        </div>

        <div class="space-y-6">
            @foreach($order->items as $item)
                <div
                    class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden flex flex-col sm:flex-row items-center sm:items-start p-6 transition hover:shadow-md">
                    <div class="w-32 h-32 bg-neutral-50 rounded-lg overflow-hidden flex-shrink-0 mb-4 sm:mb-0 sm:mr-6">
                        <img src="{{ $item->image_url }}" alt="{{ $item->product_name }}"
                            class="w-full h-full object-contain p-2">
                    </div>

                    <div class="flex-1 text-center sm:text-left">
                        <h3 class="text-lg font-bold text-leather-900 mb-1">{{ $item->product_name }}</h3>
                        <p class="text-sm text-neutral-500 mb-4">
                            Qty: {{ $item->quantity }} &bull; Rs. {{ number_format($item->price) }}
                        </p>

                        @if($item->product)
                            <a href="{{ route('reviews.create', $item->product) }}"
                                class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-md text-white bg-gold-600 hover:bg-gold-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Write a Review
                            </a>
                        @else
                            <span class="text-neutral-400 italic">Product no longer available</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="text-gold-600 hover:text-gold-700 font-medium">Return to Home</a>
        </div>
    </div>
@endsection