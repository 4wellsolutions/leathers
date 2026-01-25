<div class="w-full md:w-64 flex-shrink-0 md:mb-0">
    <div class="bg-white rounded-xl shadow-sm border border-neutral-100 overflow-hidden sticky top-24">
        <!-- Compact User Header -->
        <div class="p-4 bg-leather-900 border-b border-leather-800 flex items-center gap-3">
            <div
                class="w-10 h-10 rounded-full bg-gold-500 text-white flex items-center justify-center text-lg font-bold flex-shrink-0 border-2 border-leather-800">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="overflow-hidden">
                <h3 class="font-bold text-white text-sm truncate">{{ Auth::user()->name }}</h3>
                <p class="text-xs text-neutral-400 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <!-- Compact Navigation -->
        <div class="p-2 bg-white">
            <nav class="space-y-0.5">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-gold-50 text-gold-700' : 'text-neutral-600 hover:bg-neutral-50 hover:text-leather-900' }}">
                    <svg class="w-4 h-4 flex-shrink-0 {{ request()->routeIs('dashboard') ? 'text-gold-600' : 'text-neutral-400 group-hover:text-leather-900' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('my-orders.index') }}"
                    class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('my-orders.*') ? 'bg-gold-50 text-gold-700' : 'text-neutral-600 hover:bg-neutral-50 hover:text-leather-900' }}">
                    <svg class="w-4 h-4 flex-shrink-0 {{ request()->routeIs('my-orders.*') ? 'text-gold-600' : 'text-neutral-400 group-hover:text-leather-900' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span>My Orders</span>
                </a>

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('profile.*') ? 'bg-gold-50 text-gold-700' : 'text-neutral-600 hover:bg-neutral-50 hover:text-leather-900' }} group">
                    <svg class="w-4 h-4 flex-shrink-0 {{ request()->routeIs('profile.*') ? 'text-gold-600' : 'text-neutral-400 group-hover:text-leather-900' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>My Profile</span>
                </a>

                <div class="pt-2 mt-2 border-t border-neutral-100">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-colors group">
                            <svg class="w-4 h-4 flex-shrink-0 text-red-500 opacity-70 group-hover:opacity-100"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </nav>
        </div>
    </div>
</div>