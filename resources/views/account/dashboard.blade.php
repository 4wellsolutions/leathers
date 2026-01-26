@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <h1 class="text-3xl font-serif font-bold text-leather-900">My Dashboard</h1>
            <p class="text-neutral-500">Welcome back, <span class="font-bold text-leather-900">{{ Auth::user()->name }}</span>
            </p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 items-start">
            <!-- Sidebar (Hidden on Mobile, or you can keep it if you want consistent sidebar nav) -->
            <!-- For this compact design, we might skip the sidebar or keep it. Let's keep it consistent. -->
            @include('partials.account-sidebar')

            <!-- Main Content -->
            <div class="flex-1 w-full">

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <!-- Total Orders -->
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-neutral-200 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-neutral-400 uppercase tracking-widest">Total Orders</p>
                            <p class="text-2xl font-serif font-bold text-leather-900 mt-1">{{ $totalOrders }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-neutral-100 flex items-center justify-center text-neutral-500">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Pending -->
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-neutral-200 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-neutral-400 uppercase tracking-widest">Pending</p>
                            <p class="text-2xl font-serif font-bold text-gold-600 mt-1">{{ $pendingOrders }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-gold-50 flex items-center justify-center text-gold-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Total Spent -->
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-neutral-200 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-neutral-400 uppercase tracking-widest">Total Spent</p>
                            <p class="text-2xl font-serif font-bold text-leather-900 mt-1">Rs.
                                {{ number_format($totalSpent) }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-neutral-100 flex items-center justify-center text-neutral-500">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Split Layout -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                    <!-- Left Column: Recent Orders (2/3) -->
                    <div class="xl:col-span-2">
                        <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                            <div
                                class="px-6 py-4 border-b border-neutral-100 flex justify-between items-center bg-neutral-50/50">
                                <h3 class="font-bold text-leather-900 font-serif text-lg">Recent Orders</h3>
                                <a href="{{ route('my-orders.index') }}"
                                    class="text-xs font-bold text-gold-600 uppercase tracking-wider hover:text-gold-700">View
                                    All</a>
                            </div>

                            @if ($orders->count() > 0)
                                <!-- Desktop Table -->
                                <div class="hidden md:block overflow-x-auto">
                                    <table class="w-full text-left">
                                        <thead class="bg-neutral-50 text-neutral-500 text-[10px] uppercase tracking-wider">
                                            <tr>
                                                <th class="px-6 py-3 font-bold">Order #</th>
                                                <th class="px-6 py-3 font-bold">Date</th>
                                                <th class="px-6 py-3 font-bold">Status</th>
                                                <th class="px-6 py-3 font-bold text-right">Total</th>
                                                <th class="px-6 py-3 font-bold text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-neutral-100 text-sm">
                                            @foreach ($orders->take(5) as $order)
                                                <tr class="hover:bg-neutral-50/50 transition-colors group">
                                                    <td class="px-6 py-4">
                                                        <a href="{{ route('my-orders.show', $order->order_number) }}"
                                                            class="font-bold text-leather-900 group-hover:text-gold-600 transition-colors border-b border-transparent group-hover:border-gold-600">
                                                            {{ $order->order_number }}
                                                        </a>
                                                    </td>
                                                    <td class="px-6 py-4 text-neutral-600">
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
                                                            $statusClass =
                                                                $statusClasses[$order->status] ??
                                                                'bg-neutral-100 text-neutral-800';
                                                        @endphp
                                                        <span
                                                            class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $statusClass }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-right font-bold text-leather-900">
                                                        Rs. {{ number_format($order->total) }}
                                                    </td>
                                                    <td class="px-6 py-4 text-right">
                                                        <a href="{{ route('my-orders.show', $order->order_number) }}"
                                                            class="text-neutral-400 hover:text-gold-600 transition-colors"
                                                            title="View Details">
                                                            <svg class="w-5 h-5 inline-block" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
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

                                <!-- Mobile List -->
                                <div class="md:hidden divide-y divide-neutral-100">
                                    @foreach ($orders->take(5) as $order)
                                        <div class="p-5 flex flex-col gap-3">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <a href="{{ route('my-orders.show', $order->order_number) }}"
                                                        class="font-bold text-leather-900 border-b border-transparent hover:border-leather-900 transition-colors">
                                                        {{ $order->order_number }}
                                                    </a>
                                                    <p class="text-xs text-neutral-500 mt-1">
                                                        {{ $order->created_at->format('M d, Y') }}</p>
                                                </div>
                                                @php
                                                    $statusClasses = [
                                                        'pending' => 'bg-gold-100 text-gold-800',
                                                        'processing' => 'bg-blue-100 text-blue-800',
                                                        'shipped' => 'bg-purple-100 text-purple-800',
                                                        'delivered' => 'bg-green-100 text-green-800',
                                                        'cancelled' => 'bg-red-100 text-red-800',
                                                    ];
                                                    $statusClass =
                                                        $statusClasses[$order->status] ??
                                                        'bg-neutral-100 text-neutral-800';
                                                @endphp
                                                <span
                                                    class="px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wide {{ $statusClass }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </div>
                                            <div class="flex justify-between items-center pt-2">
                                                <p class="text-sm font-bold text-leather-900">Rs.
                                                    {{ number_format($order->total) }}</p>
                                                <a href="{{ route('my-orders.show', $order->order_number) }}"
                                                    class="text-xs font-bold text-gold-600 uppercase tracking-wider hover:underline">
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-10 text-center text-neutral-500">
                                    <svg class="w-12 h-12 mx-auto text-neutral-300 mb-3" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    <p class="mb-2">You haven't placed any orders yet.</p>
                                    <a href="{{ route('home') }}" class="btn-gold-outline inline-block mt-2">Start
                                        Shopping</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right Column: Account Snapshot (1/3) -->
                    <div>
                        <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden mb-6">
                            <div class="px-6 py-4 border-b border-neutral-100 bg-neutral-50/50 flex justify-between items-center">
                                <h3 class="font-bold text-leather-900 font-serif text-lg">Account Details</h3>
                                <a href="{{ route('profile.edit') }}" class="text-neutral-400 hover:text-gold-600"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg></a>
                            </div>
                            <div class="p-6 space-y-6">
                                <div>
                                    <h4 class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1">Contact Info</h4>
                                    <div class="flex items-center gap-3 mb-1">
                                         <div class="w-8 h-8 rounded-full bg-neutral-100 flex items-center justify-center text-neutral-500 flex-shrink-0">
                                            <span class="font-bold font-serif text-xs">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                         </div>
                                         <div>
                                             <p class="font-bold text-leather-900 text-sm">{{ Auth::user()->name }}</p>
                                             <p class="text-xs text-neutral-500">{{ Auth::user()->email }}</p>
                                         </div>
                                    </div>
                                    @if(Auth::user()->phone)
                                        <p class="text-sm text-neutral-600 pl-11">{{ Auth::user()->phone }}</p>
                                    @endif
                                </div>

                                <div class="border-t border-neutral-50 pt-4">
                                     <h4 class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-2">Default Address</h4>
                                     @if(Auth::user()->address)
                                        <div class="text-sm text-neutral-600 leading-relaxed bg-neutral-50 p-3 rounded-lg border border-neutral-100">
                                            {{ Auth::user()->address }}<br>
                                            <span class="font-bold text-leather-900">{{ Auth::user()->city }}</span>
                                        </div>
                                     @else
                                        <p class="text-sm text-neutral-400 italic">No address saved.</p>
                                        <a href="{{ route('profile.edit') }}" class="text-xs font-bold text-gold-600 mt-1 inline-block hover:underline">Add Address</a>
                                     @endif
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions? -->
                         <div class="bg-gold-600 rounded-xl shadow-lg p-6 text-white relative overflow-hidden group">
                             <div class="absolute top-0 right-0 -mr-6 -mt-6 w-24 h-24 bg-white opacity-10 rounded-full transform group-hover:scale-110 transition-transform duration-500"></div>
                             <div class="relative z-10">
                                 <h3 class="font-bold font-serif text-xl mb-1">Need Help?</h3>
                                 <p class="text-gold-100 text-sm mb-4">Track orders, returns, or product questions.</p>
                                 <a href="https://wa.me/923111222741" target="_blank" class="inline-flex items-center px-4 py-2 bg-white text-gold-900 text-xs font-bold uppercase tracking-wider rounded-lg hover:bg-gold-50 transition-colors">
                                     <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.637 3.891 1.685 5.453l-1.117 4.083 4.102-1.121z"/></svg>
                                     Chat Support
                                 </a>
                             </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection