@extends('layouts.app')

@section('title', 'My Account')

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
                            class="flex items-center space-x-3 px-4 py-2 rounded-lg bg-leather-50 text-leather-900 font-medium">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-3 px-4 py-2 rounded-lg text-neutral-600 hover:bg-neutral-50 hover:text-leather-900 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span>My Orders</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-3 px-4 py-2 rounded-lg text-neutral-600 hover:bg-neutral-50 hover:text-leather-900 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Profile</span>
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
                <h1 class="text-3xl font-serif font-bold text-leather-900 mb-8">My Dashboard</h1>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-xl shadow-md border border-neutral-100">
                        <div class="text-neutral-500 text-sm mb-1">Total Orders</div>
                        <div class="text-3xl font-bold text-leather-900">0</div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md border border-neutral-100">
                        <div class="text-neutral-500 text-sm mb-1">Pending</div>
                        <div class="text-3xl font-bold text-gold-600">0</div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md border border-neutral-100">
                        <div class="text-neutral-500 text-sm mb-1">Total Spent</div>
                        <div class="text-3xl font-bold text-leather-900">Rs. 0</div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-neutral-100 flex justify-between items-center">
                        <h2 class="font-bold text-leather-900">Recent Orders</h2>
                        <a href="#" class="text-sm text-gold-600 hover:text-gold-700 font-medium">View All</a>
                    </div>
                    <div class="p-6 text-center text-neutral-500 py-12">
                        <div class="inline-block p-4 rounded-full bg-neutral-50 mb-3">
                            <svg class="w-8 h-8 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <p>No orders found.</p>
                        <a href="{{ route('home') }}"
                            class="inline-block mt-4 text-gold-600 font-medium hover:underline">Start Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection