@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center">
        <!-- Success Icon -->
        <div
            class="inline-flex items-center justify-center p-4 rounded-full bg-gold-50 text-gold-600 mb-6 animate-scale-in shadow-sm">
            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h1 class="text-3xl md:text-4xl font-serif font-bold text-leather-900 mb-2 animate-slide-up">Order Confirmed!</h1>
        <p class="text-base text-neutral-600 mb-8 animate-slide-up" style="animation-delay: 0.1s;">
            Order <span class="font-bold text-leather-900">{{ $order->order_number }}</span> placed successfully.
        </p>

        <!-- Order Detail Card -->
        <div class="bg-white rounded-xl shadow-lg border-t-4 border-gold-500 p-6 mb-8 text-left animate-slide-up relative overflow-hidden"
            style="animation-delay: 0.2s;">


            <div class="flex items-center justify-between mb-6 border-b border-neutral-100 pb-3">
                <h2 class="text-lg font-serif font-bold text-leather-900">Order Details</h2>
                <span
                    class="px-2.5 py-0.5 bg-green-100 text-green-700 text-[10px] font-bold uppercase tracking-wider rounded-full">Paid:
                    COD</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-[10px] font-bold text-gold-600 uppercase tracking-widest mb-2">Shipping To</h3>
                    <div class="space-y-0.5 text-sm text-neutral-600">
                        <p class="font-bold text-leather-900">{{ $order->customer_name }}</p>
                        <p>{{ $order->shipping_address }}</p>
                        <p>{{ $order->city }}</p>
                        <p class="pt-1 text-xs">{{ $order->customer_phone }}</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-[10px] font-bold text-gold-600 uppercase tracking-widest mb-2">Summary</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-neutral-600">Subtotal</span>
                            <span class="text-leather-900 font-medium">Rs. {{ number_format($order->subtotal) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-neutral-600">Shipping</span>
                            @if($order->shipping_cost > 0)
                                <span class="text-leather-900 font-medium">Rs. {{ number_format($order->shipping_cost) }}</span>
                            @else
                                <span class="text-green-600 font-medium">Free</span>
                            @endif
                        </div>
                        <div class="flex justify-between pt-2 border-t border-dashed border-neutral-200 mt-1">
                            <span class="text-base font-bold text-leather-900">Total</span>
                            <span class="text-xl font-serif font-bold text-gold-600">Rs.
                                {{ number_format($order->total) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="animate-slide-up space-y-4" style="animation-delay: 0.3s;">
            <p class="text-neutral-400 text-xs mb-4">
                Confirmation sent to {{ $order->customer_email }}
            </p>
            <a href="{{ route('home') }}"
                class="inline-flex items-center justify-center px-8 py-3 bg-leather-900 text-white text-sm font-bold uppercase tracking-wide rounded-lg hover:bg-leather-800 transition-colors shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                Continue Shopping
            </a>
        </div>
    </div>

    @push('scripts')
        <script>
            gtag('event', 'conversion', {
                'send_to': 'AW-17950154997/{{ config("services.google_ads.conversion_label", "") }}',
                'value': {{ $order->total }},
                'currency': 'PKR',
                'transaction_id': '{{ $order->order_number }}'
            });
        </script>
    @endpush
@endsection