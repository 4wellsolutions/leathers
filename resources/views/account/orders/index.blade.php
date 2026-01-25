@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Sidebar -->
            <div class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center space-x-4 mb-6">
                        <div
                            class="h-12 w-12 rounded-full bg-leather-100 flex items-center justify-center text-leather-700 font-bold text-xl">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-leather-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-neutral-500">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <nav class="space-y-2">
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center space-x-3 px-4 py-2 rounded-lg text-neutral-600 hover:bg-neutral-50 hover:text-leather-900 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('my-orders.index') }}"
                            class="flex items-center space-x-3 px-4 py-2 rounded-lg bg-leather-50 text-leather-900 font-medium">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span>My Orders</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="pt-4 mt-4 border-t border-neutral-100">
                            @csrf
                            <button type="submit"
                                class="flex w-full items-center space-x-3 px-4 py-2 rounded-lg text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-grow">
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
                        <div class="overflow-x-auto">
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