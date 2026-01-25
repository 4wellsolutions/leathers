@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col md:flex-row gap-8 items-start">

            <!-- Sidebar -->
            @include('partials.account-sidebar')

            <!-- Main Content -->
            <div class="flex-1 w-full">

                <!-- Three Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Total Orders -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-neutral-200">
                        <p class="text-sm font-medium text-neutral-500 uppercase tracking-wide">Total Orders</p>
                        <p class="text-3xl font-bold text-neutral-900 mt-2">{{ $totalOrders }}</p>
                    </div>

                    <!-- Pending -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-neutral-200">
                        <p class="text-sm font-medium text-neutral-500 uppercase tracking-wide">Pending</p>
                        <p class="text-3xl font-bold text-gold-600 mt-2">{{ $pendingOrders }}</p>
                    </div>

                    <!-- Total Spent -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-neutral-200">
                        <p class="text-sm font-medium text-neutral-500 uppercase tracking-wide">Total Spent</p>
                        <p class="text-3xl font-bold text-neutral-900 mt-2">Rs. {{ number_format($totalSpent) }}</p>
                    </div>
                </div>

                <!-- Dashboard Widgets Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Recent Orders (2/3 width) -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-sm border border-neutral-200 overflow-hidden">
                            <div
                                class="px-6 py-4 border-b border-neutral-200 flex justify-between items-center bg-neutral-50">
                                <h3 class="font-bold text-neutral-900">Recent Orders</h3>
                                <a href="{{ route('my-orders.index') }}"
                                    class="text-sm font-medium text-gold-600 hover:text-gold-700">View All</a>
                            </div>

                            @if($orders->count() > 0)
                                <!-- Desktop View (Table) -->
                                <div class="hidden md:block overflow-x-auto">
                                    <table class="w-full text-left">
                                        <thead
                                            class="bg-neutral-50 text-neutral-500 text-xs uppercase tracking-wider border-b border-neutral-100">
                                            <tr>
                                                <th class="px-6 py-4 font-semibold">Order #</th>
                                                <th class="px-6 py-4 font-semibold">Date</th>
                                                <th class="px-6 py-4 font-semibold">Status</th>
                                                <th class="px-6 py-4 font-semibold text-right">Total</th>
                                                <th class="px-6 py-4 font-semibold text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-neutral-100">
                                            @foreach($orders->take(5) as $order)
                                                                        <tr class="hover:bg-neutral-50 transition-colors group">
                                                                            <td
                                                                                class="px-6 py-4 font-bold text-leather-900 group-hover:text-gold-600 transition-colors">
                                                                                {{ $order->order_number }}
                                                                            </td>
                                                                            <td class="px-6 py-4 text-sm text-neutral-600">
                                                                                {{ $order->created_at->format('M d, Y') }}
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
                                                                                    class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide {{ $statusClass }}">
                                                                                    {{ ucfirst($order->status) }}
                                                                                </span>
                                                                            </td>
                                                                            <td class="px-6 py-4 text-right font-medium text-neutral-900">
                                                                                Rs. {{ number_format($order->total) }}
                                                                            </td>
                                                                            <td class="px-6 py-4 text-right">
                                                                                <a href="{{ route('my-orders.show', $order->order_number) }}"
                                                                                    class="text-neutral-400 hover:text-gold-600 transition-colors">
                                                                                    <svg class="w-5 h-5 inline-block" fill="none" viewBox="0 0 24 24"
                                                                                        stroke="currentColor">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                                            stroke-width="2" d="M9 5l7 7-7 7" />
                                                                                    </svg>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Mobile View (Cards) -->
                                <div class="md:hidden divide-y divide-neutral-100">
                                    @foreach($orders->take(5) as $order)
                                                            <div class="p-5 space-y-4">
                                                                <div class="flex justify-between items-start">
                                                                    <div>
                                                                        <span class="text-xs font-bold text-neutral-400 uppercase tracking-wider">Order
                                                                            #</span>
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
                                                                        <span
                                                                            class="text-xs font-bold text-neutral-400 uppercase tracking-wider">Total</span>
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
                            @else
                                <div class="p-8 text-center text-neutral-500">
                                    <p>No orders found.</p>
                                    <a href="{{ route('home') }}"
                                        class="text-gold-600 font-medium hover:underline mt-2 inline-block">Start Shopping</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Account Snapshot (1/3 width) -->
                    <div>
                        <div class="bg-white rounded-lg shadow-sm border border-neutral-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-neutral-200 bg-neutral-50">
                                <h3 class="font-bold text-neutral-900">Account Details</h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <div>
                                    <h4 class="text-xs font-bold text-neutral-400 uppercase tracking-wide mb-1">Contact</h4>
                                    <p class="text-sm text-neutral-700">{{ Auth::user()->email }}</p>
                                    <p class="text-sm text-neutral-700">{{ Auth::user()->phone ?? 'No phone added' }}</p>
                                </div>

                                @php
                                    $latestOrder = $orders->first();
                                @endphp
                                @if($latestOrder)
                                    <div>
                                        <h4 class="text-xs font-bold text-neutral-400 uppercase tracking-wide mb-1">Default
                                            Address</h4>
                                        <div class="text-sm text-neutral-700">
                                            <p class="font-medium">{{ $latestOrder->customer_name }}</p>
                                            <p>{{ $latestOrder->shipping_address }}</p>
                                            <p>{{ $latestOrder->city }}</p>
                                        </div>
                                        <p class="text-xs text-neutral-400 mt-1 italic">Based on last order</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection