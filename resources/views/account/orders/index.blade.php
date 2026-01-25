@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col md:flex-row gap-4 md:gap-8 items-start">

            <!-- Sidebar Navigation -->
            @include('partials.account-sidebar')

            <!-- Main Content -->
            <div class="flex-1 w-full">
                <h1 class="text-3xl font-serif font-bold text-leather-900 mb-8">My Orders</h1>

                <!-- Status Filters -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <a href="{{ route('my-orders.index') }}"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-colors border {{ !request('status') || request('status') == 'all' ? 'bg-leather-900 text-white border-leather-900' : 'bg-white text-neutral-600 border-neutral-200 hover:border-leather-900 hover:text-leather-900' }}">
                        All Orders
                    </a>
                    <a href="{{ route('my-orders.index', ['status' => 'pending']) }}"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-colors border {{ request('status') == 'pending' ? 'bg-gold-500 text-white border-gold-500' : 'bg-white text-neutral-600 border-neutral-200 hover:border-gold-500 hover:text-gold-600' }}">
                        Pending
                    </a>
                    <a href="{{ route('my-orders.index', ['status' => 'processing']) }}"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-colors border {{ request('status') == 'processing' ? 'bg-blue-500 text-white border-blue-500' : 'bg-white text-neutral-600 border-neutral-200 hover:border-blue-500 hover:text-blue-600' }}">
                        Processing
                    </a>
                    <a href="{{ route('my-orders.index', ['status' => 'shipped']) }}"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-colors border {{ request('status') == 'shipped' ? 'bg-purple-500 text-white border-purple-500' : 'bg-white text-neutral-600 border-neutral-200 hover:border-purple-500 hover:text-purple-600' }}">
                        Shipped
                    </a>
                    <a href="{{ route('my-orders.index', ['status' => 'delivered']) }}"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-colors border {{ request('status') == 'delivered' ? 'bg-green-600 text-white border-green-600' : 'bg-white text-neutral-600 border-neutral-200 hover:border-green-600 hover:text-green-600' }}">
                        Delivered
                    </a>
                    <a href="{{ route('my-orders.index', ['status' => 'cancelled']) }}"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-colors border {{ request('status') == 'cancelled' ? 'bg-red-500 text-white border-red-500' : 'bg-white text-neutral-600 border-neutral-200 hover:border-red-500 hover:text-red-500' }}">
                        Cancelled
                    </a>
                </div>

                <!-- Orders List -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-neutral-100">
                    @if($orders->count() > 0)
                        <!-- Desktop View (Table) -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-neutral-50 text-neutral-500 text-xs uppercase tracking-wider">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold">Order #</th>
                                        <th class="px-6 py-4 font-semibold">Date</th>
                                        <th class="px-6 py-4 font-semibold">Status</th>
                                        <th class="px-6 py-4 font-semibold">Total</th>
                                        <th class="px-6 py-4 font-semibold text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-neutral-100">
                                    @foreach($orders as $order)
                                                            <tr class="hover:bg-neutral-50 transition-colors group">
                                                                <td
                                                                    class="px-6 py-4 font-bold text-leather-900 group-hover:text-gold-600 transition-colors">
                                                                    {{ $order->order_number }}
                                                                </td>
                                                                <td class="px-6 py-4 text-sm text-neutral-600">
                                                                    {{ $order->created_at->format('M d, Y') }}
                                                                    <span
                                                                        class="block text-xs text-neutral-400">{{ $order->created_at->format('h:i A') }}</span>
                                                                </td>
                                                                <td class="px-6 py-4">
                                                                    @php
                                                                        $statusClasses = [
                                                                            'pending' => 'bg-gold-100 text-gold-800',
                                                                            'processing' => 'bg-blue-100 text-blue-800',
                                                                            'shipped' => 'bg-purple-100 text-purple-800',
                                                                            'delivered' => 'bg-green-100 text-green-800',
                                                                            'cancelled' => 'bg-red-100 text-red-800',
                                                                        ];
                                                                        $statusClass = $statusClasses[$order->status] ?? 'bg-neutral-100 text-neutral-800';
                                                                    @endphp
                                         <span
                                                                        class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide {{ $statusClass }}">
                                                                        {{ ucfirst($order->status) }}
                                                                    </span>
                                                                </td>
                                                                <td class="px-6 py-4 font-bold text-leather-900 font-serif">
                                                                    Rs. {{ number_format($order->total) }}
                                                                </td>
                                                                <td class="px-6 py-4 text-right">
                                                                    <a href="{{ route('my-orders.show', $order->order_number) }}"
                                                                        class="inline-block px-4 py-2 bg-white border border-neutral-200 text-neutral-600 text-sm font-medium rounded-lg hover:border-gold-500 hover:text-gold-600 transition-all shadow-sm">
                                                                        View Details
                                                                    </a>
                                                                </td>
                                                            </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile View (Cards) -->
                        <div class="md:hidden divide-y divide-neutral-100">
                            @foreach($orders as $order)
                                            <div class="p-5 space-y-4">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <span class="text-xs font-bold text-neutral-400 uppercase tracking-wider">Order #</span>
                                                        <p class="font-bold text-leather-900 text-lg">{{ $order->order_number }}</p>
                                                        <p class="text-xs text-neutral-500 mt-1">
                                                            {{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                                                    </div>
                                                    @php
                                                        $statusClasses = [
                                                            'pending' => 'bg-gold-100 text-gold-800',
                                                            'processing' => 'bg-blue-100 text-blue-800',
                                                            'shipped' => 'bg-purple-100 text-purple-800',
                                                            'delivered' => 'bg-green-100 text-green-800',
                                                            'cancelled' => 'bg-red-100 text-red-800',
                                                        ];
                                                        $statusClass = $statusClasses[$order->status] ?? 'bg-neutral-100 text-neutral-800';
                                                    @endphp
                                 <span
                                                        class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wide {{ $statusClass }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </div>

                                                <div class="flex justify-between items-end border-t border-neutral-50 pt-4">
                                                    <div>
                                                        <span class="text-xs font-bold text-neutral-400 uppercase tracking-wider">Total
                                                            Amount</span>
                                                        <p class="font-serif font-bold text-xl text-leather-900">Rs.
                                                            {{ number_format($order->total) }}</p>
                                                    </div>
                                                    <a href="{{ route('my-orders.show', $order->order_number) }}"
                                                        class="px-4 py-2 bg-neutral-900 text-white text-sm font-bold rounded-lg hover:bg-gold-600 transition-colors shadow-sm">
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="px-6 py-4 border-t border-neutral-100 bg-neutral-50">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="p-12 text-center text-neutral-500">
                            <div class="inline-block p-4 rounded-full bg-neutral-50 mb-4">
                                <svg class="w-10 h-10 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-leather-900 mb-2">No orders found</h3>
                            <p class="mb-6">You haven't placed any orders with this status yet.</p>
                            <a href="{{ route('home') }}"
                                class="inline-flex items-center justify-center px-6 py-2.5 bg-gold-500 text-white font-bold rounded-lg hover:bg-gold-600 transition-colors shadow-md">
                                Start Shopping
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection