@extends('layouts.app')

@section('meta_title', 'Review Your Order #' . $order->order_number)

@section('content')
    <div class="bg-gray-50 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="max-w-7xl mx-auto text-center mb-12">
            <h1 class="text-4xl font-serif font-bold text-leather-900 mb-3">Review Your Order</h1>
            <p class="text-neutral-500 text-lg">
                Order #{{ $order->order_number }} &bull; {{ $order->created_at->format('F d, Y') }}
            </p>
        </div>

        {{-- Product Grid --}}
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($order->items as $item)
                <div
                    class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden flex flex-col items-center p-8 text-center transition hover:shadow-md">
                    {{-- Image --}}
                    <div class="w-48 h-48 bg-neutral-50 rounded-xl overflow-hidden mb-6 flex items-center justify-center">
                        <img src="{{ $item->image_url }}" alt="{{ $item->product_name }}"
                            class="w-full h-full object-contain p-2 mix-blend-multiply">
                    </div>

                    {{-- Product Details --}}
                    <div class="mb-6 flex-grow">
                        <h3 class="text-lg font-bold text-leather-900 mb-2 leading-tight px-4">
                            {{ $item->product_name }}
                        </h3>
                        <p class="text-neutral-500">
                            Qty: {{ $item->quantity }} &bull; Rs. {{ number_format($item->price) }}
                        </p>
                    </div>

                    {{-- Action Button --}}
                    <div class="w-full">
                        @if($item->product)
                            <a href="{{ route('reviews.create', $item->product) }}"
                                class="inline-flex items-center justify-center w-full px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Write a Review
                            </a>
                        @else
                            <span
                                class="inline-block w-full py-3 text-neutral-400 bg-neutral-50 rounded-lg border border-neutral-200 cursor-not-allowed">
                                Product Unavailable
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Footer Link --}}
        <div class="mt-12 text-center">
            <a href="{{ route('home') }}"
                class="text-yellow-600 hover:text-yellow-700 font-medium inline-flex items-center">
                Return to Home
            </a>
        </div>
    </div>

    {{-- WhatsApp Floating Button (as seen in screenshot) --}}
    <a href="https://wa.me/923001234567" target="_blank"
        class="fixed bottom-6 right-6 z-50 bg-green-500 text-white p-3 rounded-full shadow-lg hover:bg-green-600 transition transform hover:scale-110">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
            <path
                d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.897.001-6.621 5.396-12.023 12.022-12.023 3.213.001 6.231 1.253 8.502 3.524 2.269 2.271 3.518 5.29 3.518 8.502 0 6.62-5.398 12.022-12.023 12.022-2.091-.001-4.132-.56-5.879-1.621l-6.24 1.656zm6.577-4.102l.33.195c1.558.922 3.123 1.354 4.887 1.354 5.378 0 9.754-4.376 9.754-9.754-.001-2.606-1.015-5.056-2.855-6.897-1.839-1.838-4.288-2.854-6.896-2.854-5.378 0-9.754 4.376-9.754 9.754 0 1.834.498 3.655 1.458 5.275l.215.358-1.006 3.673 3.867-1.011zm5.289-2.739c-.282-.141-1.666-.821-1.924-.915-.258-.095-.445-.141-.634.141-.188.282-.729.915-894 1.103-.165.188-.329.211-.611.071-.282-.141-1.189-.439-2.265-1.4-1.291-1.152-2.164-2.574-2.418-3.008-.254-.435-.027-.67.114-.811.128-.128.282-.329.423-.494.141-.165.188-.282.282-.47.094-.188.047-.353-.023-.494-.071-.141-.634-1.528-.868-2.094-.228-.553-.46-.477-.633-.487-.165-.009-.353-.01-.541-.01-.188 0-.493.071-.75.353-.258.282-.987.964-.987 2.352 0 1.388 1.01 2.729 1.151 2.917.141.188 1.988 3.036 4.815 4.257.672.29 1.196.463 1.604.593.679.215 1.297.185 1.787.112.548-.081 1.666-.68 1.901-1.336.235-.656.235-1.218.165-1.336-.07-.118-.258-.188-.54-.329z" />
        </svg>
    </a>
@endsection