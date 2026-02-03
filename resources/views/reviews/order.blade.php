@extends('layouts.app')

@section('meta_title', 'Review Your Order #' . $order->order_number)

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8 text-center sm:text-left">
            <h1 class="text-3xl font-serif font-bold text-leather-900 mb-2">Review Your Order</h1>
            <p class="text-neutral-600">Order #{{ $order->order_number }} &bull; {{ $order->created_at->format('F d, Y') }}
            </p>
        </div>

        {{-- Desktop Table View --}}
        <div class="hidden md:block bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-neutral-50 border-b border-neutral-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-neutral-500 uppercase tracking-wider">Product
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-neutral-500 uppercase tracking-wider">
                            Quantity</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-neutral-500 uppercase tracking-wider">Price
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-neutral-500 uppercase tracking-wider">Action
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200">
                    @foreach ($order->items as $item)
                        <tr class="hover:bg-neutral-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16 bg-neutral-100 rounded-md overflow-hidden">
                                        <img class="h-16 w-16 object-contain p-2" src="{{ $item->image_url }}"
                                            alt="{{ $item->product_name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-leather-900">{{ $item->product_name }}</div>
                                        @if ($item->variant && $item->variant->color)
                                        <p class="text-xs text-neutral-500 mt-1">
                                            Color: {{ $item->variant->color->name }}
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-leather-900">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-bold text-leather-900">
                                Rs. {{ number_format($item->price) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($item->product)
                                    <a href="{{ route('reviews.create', $item->product) }}"
                                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-xs font-bold uppercase tracking-wider rounded-md text-white bg-gold-600 hover:bg-gold-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-colors">
                                        Write Review
                                    </a>
                                @else
                                    <span class="text-xs text-neutral-400 italic">Unavailable</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile List View --}}
        <div class="md:hidden space-y-4">
            @foreach ($order->items as $item)
                <div class="bg-white rounded-xl shadow-sm p-4 flex gap-4 border border-neutral-100">
                    {{-- Image --}}
                    <div class="flex-shrink-0 w-20 h-20 bg-neutral-100 rounded-lg overflow-hidden">
                        <img class="w-full h-full object-contain p-2" src="{{ $item->image_url }}"
                            alt="{{ $item->product_name }}">
                    </div>

                    {{-- Content --}}
                    <div class="flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="text-sm font-bold text-leather-900 line-clamp-2 leading-tight mb-1">
                                {{ $item->product_name }}
                            </h3>
                            <div class="flex justify-between items-start">
                                <div>
                                    @if ($item->variant && $item->variant->color)
                                    <p class="text-xs text-neutral-500 mb-1">
                                        Color: {{ $item->variant->color->name }}
                                    </p>
                                    @endif
                                    <p class="text-xs text-neutral-500">
                                        Qty: {{ $item->quantity }} &bull; Rs. {{ number_format($item->price) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            @if ($item->product)
                                <a href="{{ route('reviews.create', $item->product) }}"
                                    class="block w-full text-center px-4 py-2.5 bg-gold-600 text-white text-xs font-bold uppercase tracking-wide rounded-lg hover:bg-gold-700 transition-colors shadow-sm">
                                    <svg class="w-3 h-3 inline-block mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Write a Review
                                </a>
                            @else
                                <span class="block w-full text-center py-2 text-xs text-neutral-400 bg-neutral-50 rounded-lg border border-neutral-100 italic">
                                    Unavailable
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="text-gold-600 hover:text-gold-700 font-medium text-sm">Return to
                Home</a>
        </div>
    </div>
    
    {{-- WhatsApp Floating Button --}}
    <a href="https://wa.me/923001234567" target="_blank"
        class="fixed bottom-6 right-6 z-50 bg-green-500 text-white p-3 rounded-full shadow-lg hover:bg-green-600 transition transform hover:scale-110">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
            <path
                d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.897.001-6.621 5.396-12.023 12.022-12.023 3.213.001 6.231 1.253 8.502 3.524 2.269 2.271 3.518 5.29 3.518 8.502 0 6.62-5.398 12.022-12.023 12.022-2.091-.001-4.132-.56-5.879-1.621l-6.24 1.656zm6.577-4.102l.33.195c1.558.922 3.123 1.354 4.887 1.354 5.378 0 9.754-4.376 9.754-9.754-.001-2.606-1.015-5.056-2.855-6.897-1.839-1.838-4.288-2.854-6.896-2.854-5.378 0-9.754 4.376-9.754 9.754 0 1.834.498 3.655 1.458 5.275l.215.358-1.006 3.673 3.867-1.011zm5.289-2.739c-.282-.141-1.666-.821-1.924-.915-.258-.095-.445-.141-.634.141-.188.282-.729.915-894 1.103-.165.188-.329.211-.611.071-.282-.141-1.189-.439-2.265-1.4-1.291-1.152-2.164-2.574-2.418-3.008-.254-.435-.027-.67.114-.811.128-.128.282-.329.423-.494.141-.165.188-.282.282-.47.094-.188.047-.353-.023-.494-.071-.141-.634-1.528-.868-2.094-.228-.553-.46-.477-.633-.487-.165-.009-.353-.01-.541-.01-.188 0-.493.071-.75.353-.258.282-.987.964-.987 2.352 0 1.388 1.01 2.729 1.151 2.917.141.188 1.988 3.036 4.815 4.257.672.29 1.196.463 1.604.593.679.215 1.297.185 1.787.112.548-.081 1.666-.68 1.901-1.336.235-.656.235-1.218.165-1.336-.07-.118-.258-.188-.54-.329z" />
        </svg>
    </a>
@endsection