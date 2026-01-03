@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Orders -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">Total Orders</dt>
                            <dd class="text-lg font-medium text-leather-900">{{ \App\Models\Order::count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-neutral-50 px-5 py-3">
                <div class="text-sm">
                    <a href="#" class="font-medium text-gold-600 hover:text-gold-500">View all</a>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">Total Revenue</dt>
                            <dd class="text-lg font-medium text-leather-900">Rs. {{ number_format(\App\Models\Order::sum('total')) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-neutral-50 px-5 py-3">
                <div class="text-sm">
                    <a href="#" class="font-medium text-gold-600 hover:text-gold-500">View all</a>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">Total Products</dt>
                            <dd class="text-lg font-medium text-leather-900">{{ \App\Models\Product::count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-neutral-50 px-5 py-3">
                <div class="text-sm">
                    <a href="#" class="font-medium text-gold-600 hover:text-gold-500">View all</a>
                </div>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">Total Customers</dt>
                            <dd class="text-lg font-medium text-leather-900">{{ \App\Models\User::where('is_admin', false)->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-neutral-50 px-5 py-3">
                <div class="text-sm">
                    <a href="#" class="font-medium text-gold-600 hover:text-gold-500">View all</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="mt-8">
        <h2 class="text-lg leading-6 font-medium text-leather-900 mb-4">Recent Orders</h2>
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-neutral-200">
                @forelse(\App\Models\Order::latest()->take(5)->get() as $order)
                <li>
                    <a href="#" class="block hover:bg-neutral-50">
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gold-600 truncate">
                                    {{ $order->order_number }}
                                </p>
                                <div class="ml-2 flex-shrink-0 flex">
                                    <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ ucfirst($order->status) }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-2 sm:flex sm:justify-between">
                                <div class="sm:flex">
                                    <p class="flex items-center text-sm text-neutral-500">
                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        {{ $order->customer_name }}
                                    </p>
                                </div>
                                <div class="mt-2 flex items-center text-sm text-neutral-500 sm:mt-0">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p>
                                        Placed on <time datetime="{{ $order->created_at }}">{{ $order->created_at->format('M d, Y') }}</time>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                @empty
                <li class="px-4 py-4 sm:px-6 text-center text-neutral-500">
                    No orders found.
                </li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
