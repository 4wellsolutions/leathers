@extends('layouts.invoice')

@section('title', 'Invoice #' . $order->order_number)

@section('content')
    <!-- Header -->
    <div class="flex justify-between items-start mb-12 border-b border-neutral-100 pb-8">
        <div>
            <h1 class="text-3xl font-serif font-bold text-leather-900 mb-2">Leathers.pk</h1>
            <p class="text-sm text-neutral-500">Premium Leather Goods</p>
        </div>
        <div class="text-right">
            <h2 class="text-2xl font-bold text-neutral-900 uppercase tracking-widest text-[#B88E2F]">Invoice</h2>
            <p class="text-sm text-neutral-500 mt-1">#{{ $order->order_number }}</p>
            <p class="text-sm text-neutral-500">{{ $order->created_at->format('F d, Y') }}</p>
        </div>
    </div>

    <!-- Bill To / Ship To -->
    <div class="grid grid-cols-2 gap-8 mb-12">
        <div>
            <h3 class="text-xs font-bold text-neutral-400 uppercase tracking-wider mb-3">Bill To</h3>
            <p class="font-bold text-neutral-900">{{ $order->customer_name }}</p>
            <p class="text-sm text-neutral-600 mt-1">{{ $order->customer_email }}</p>
            <p class="text-sm text-neutral-600">{{ $order->customer_phone }}</p>
        </div>
        <div>
            <h3 class="text-xs font-bold text-neutral-400 uppercase tracking-wider mb-3">Ship To</h3>
            <p class="font-bold text-neutral-900">{{ $order->customer_name }}</p>
            <div class="text-sm text-neutral-600 mt-1">
                <p>{{ $order->shipping_address }}</p>
                <p>{{ $order->city }}</p>
            </div>
        </div>
    </div>

    <!-- Items -->
    <table class="w-full text-left mb-12">
        <thead class="bg-neutral-50 text-xs font-bold text-neutral-500 uppercase tracking-wider">
            <tr>
                <th class="px-6 py-4 rounded-l-lg">Item</th>
                <th class="px-6 py-4 text-center">Qty</th>
                <th class="px-6 py-4 text-right rounded-r-lg">Price</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-neutral-100">
            @foreach($order->items as $item)
                <tr>
                    <td class="px-6 py-4">
                        <p class="font-bold text-neutral-900">{{ $item->product_name }}</p>
                        @if($item->variant_name)
                            <p class="text-xs text-neutral-500">{{ $item->variant_name }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center text-neutral-600">{{ $item->quantity }}</td>
                    <td class="px-6 py-4 text-right font-medium text-neutral-900">Rs.
                        {{ number_format($item->price * $item->quantity) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="flex justify-end mb-12">
        <div class="w-64 space-y-3">
            <div class="flex justify-between text-sm text-neutral-600">
                <span>Subtotal</span>
                <span>Rs. {{ number_format($order->subtotal) }}</span>
            </div>
            <div class="flex justify-between text-sm text-neutral-600">
                <span>Shipping</span>
                <span>Rs. {{ number_format($order->shipping_cost) }}</span>
            </div>
            <div class="flex justify-between text-lg font-bold text-leather-900 border-t border-neutral-100 pt-3">
                <span>Total</span>
                <span>Rs. {{ number_format($order->total) }}</span>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center text-sm text-neutral-500 pt-8 border-t border-neutral-100">
        <p class="mb-2">Thank you for your business!</p>
        <p class="text-xs">If you have any questions, please contact us at support@leathers.pk</p>
    </div>

    <!-- Print Button (Hidden in Print) -->
    <div class="fixed bottom-8 right-8 no-print">
        <button onclick="window.print()"
            class="bg-[#B88E2F] hover:bg-[#a07b28] text-white rounded-full p-4 shadow-lg transition-transform hover:scale-105">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
        </button>
    </div>
@endsection

@section('scripts')
    <script>
        window.onload = function () {
            setTimeout(function () {
                window.print();
            }, 500);
        };
    </script>
@endsection