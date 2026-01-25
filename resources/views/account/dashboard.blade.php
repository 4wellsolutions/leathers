@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Sidebar Navigation (Compact & Sticky) -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-sm border border-neutral-100 sticky top-24 overflow-hidden">
                    <!-- User Profile Header -->
                    <div class="p-5 border-b border-neutral-100 bg-neutral-50/50 text-center">
                        <div
                            class="h-16 w-16 rounded-full bg-gold-100 flex items-center justify-center text-gold-700 font-bold text-2xl mx-auto mb-3 border-2 border-white shadow-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h2 class="font-bold text-leather-900 truncate">{{ Auth::user()->name }}</h2>
                        <p class="text-xs text-neutral-500 truncate">{{ Auth::user()->email }}</p>
                    </div>

                    <!-- Navigation Links -->
                    <nav class="p-2 space-y-1">
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center space-x-3 px-3 py-2.5 rounded-lg bg-leather-900 text-white font-medium transition-all shadow-sm">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span>Overview</span>
                        </a>
                        <a href="{{ route('my-orders.index') }}"
                            class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-neutral-600 hover:bg-neutral-50 hover:text-leather-900 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span>My Orders</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-neutral-600 hover:bg-neutral-50 hover:text-leather-900 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Profile Settings</span>
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="pt-2 mt-2 border-t border-neutral-100">
                            @csrf
                            <button type="submit"
                                class="flex w-full items-center space-x-3 px-3 py-2.5 rounded-lg text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="lg:col-span-9 space-y-6">

                <!-- Quick Stats Row -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-neutral-100 flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-neutral-400 uppercase tracking-wider">Total Orders</p>
                            <p class="text-2xl font-bold text-leather-900">{{ $totalOrders }}</p>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl shadow-sm border border-neutral-100 flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full bg-gold-50 flex items-center justify-center text-gold-600">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-neutral-400 uppercase tracking-wider">Pending</p>
                            <p class="text-2xl font-bold text-gold-600">{{ $pendingOrders }}</p>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl shadow-sm border border-neutral-100 flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-neutral-400 uppercase tracking-wider">Total Spent</p>
                            <p class="text-xl font-bold text-leather-900 leading-tight">Rs. {{ number_format($totalSpent) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Recent Orders Table (Takes 2/3 width) -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-sm border border-neutral-100 h-full">
                            <div class="px-5 py-4 border-b border-neutral-100 flex justify-between items-center">
                                <h3 class="font-bold text-lg text-leather-900 font-serif">Recent Orders</h3>
                                <a href="{{ route('my-orders.index') }}"
                                    class="text-xs font-bold text-gold-600 hover:text-gold-700 uppercase tracking-wide">View
                                    All</a>
                            </div>

                            @if($orders->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left">
                                        <thead class="bg-neutral-50/50 text-neutral-500 text-[10px] uppercase tracking-wider">
                                            <tr>
                                                <th class="px-5 py-3 font-semibold">Order ID</th>
                                                <th class="px-5 py-3 font-semibold">Status</th>
                                                <th class="px-5 py-3 font-semibold text-right">Amount</th>
                                                <th class="px-5 py-3 font-semibold"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-neutral-100 text-sm">
                                            @foreach($orders->take(5) as $order)
                                                <tr class="hover:bg-neutral-50 transition-colors group">
                                                    <td class="px-5 py-3">
                                                        <span
                                                            class="font-bold text-leather-900 group-hover:text-gold-600 transition-colors block">{{ $order->order_number }}</span>
                                                        <span
                                                            class="text-xs text-neutral-400">{{ $order->created_at->format('M d') }}</span>
                                                    </td>
                                                    <td class="px-5 py-3">
                                                        @php
                                                            $statusColors = [
                                                                'pending' => 'text-gold-600 bg-gold-50',
                                                                'processing' => 'text-blue-600 bg-blue-50',
                                                                'shipped' => 'text-purple-600 bg-purple-50',
                                                                'delivered' => 'text-green-600 bg-green-50',
                                                                'cancelled' => 'text-red-600 bg-red-50',
                                                            ];
                                                            $color = $statusColors[$order->status] ?? 'text-neutral-600 bg-neutral-50';
                                                        @endphp
                                                        <span
                                                            class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wide {{ $color }}">
                                                            {{ $order->status }}
                                                        </span>
                                                    </td>
                                                    <td class="px-5 py-3 text-right font-medium text-leather-900">
                                                        Rs. {{ number_format($order->total) }}
                                                    </td>
                                                    <td class="px-5 py-3 text-right">
                                                        <a href="{{ route('my-orders.show', $order->order_number) }}"
                                                            class="text-neutral-400 hover:text-gold-600 transition-colors">
                                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
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
                            @else
                                <div class="p-8 text-center text-neutral-500">
                                    <p class="text-sm">No recent orders found.</p>
                                    <a href="{{ route('home') }}"
                                        class="text-gold-600 hover:underline text-sm font-bold mt-2 inline-block">Start
                                        Shopping</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Account Details Card (Takes 1/3 width) -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow-sm border border-neutral-100 h-full">
                            <div class="px-5 py-4 border-b border-neutral-100">
                                <h3 class="font-bold text-lg text-leather-900 font-serif">Account Details</h3>
                            </div>
                            <div class="p-5 space-y-6">
                                <div>
                                    <h4 class="text-xs font-bold text-neutral-400 uppercase tracking-widest mb-2">Contact
                                        Info</h4>
                                    <div class="space-y-2 text-sm text-neutral-600">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <span class="truncate">{{ Auth::user()->email }}</span>
                                        </div>
                                        @if(Auth::user()->phone)
                                            <div class="flex items-center gap-3">
                                                <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                <span>{{ Auth::user()->phone }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @php
                                    $latestOrder = $orders->first();
                                @endphp
                                @if($latestOrder)
                                    <div>
                                        <h4 class="text-xs font-bold text-neutral-400 uppercase tracking-widest mb-2">Default
                                            Address</h4>
                                        <div class="p-3 bg-neutral-50 rounded-lg text-sm text-neutral-600">
                                            <p class="font-bold text-leather-900">{{ $latestOrder->customer_name }}</p>
                                            <p class="line-clamp-2">{{ $latestOrder->shipping_address }}</p>
                                            <p>{{ $latestOrder->city }}</p>
                                        </div>
                                        <p class="text-[10px] text-neutral-400 mt-2">* Based on your last order</p>
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