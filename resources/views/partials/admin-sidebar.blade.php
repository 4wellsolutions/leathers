<div class="flex flex-col h-0 flex-1 bg-leather-900 border-r border-leather-800">
    <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
        <div class="flex items-center flex-shrink-0 px-4 mb-6">
            <span class="text-2xl font-serif font-bold text-gold-400 tracking-wider">LEATHERS<span
                    class="text-white">.PK</span></span>
        </div>
        <nav class="mt-5 flex-1 px-2 space-y-1" x-data="{ open: null }">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
                class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-leather-800 text-white' : 'text-neutral-300 hover:bg-leather-700 hover:text-white' }}">
                <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('admin.dashboard') ? 'text-gold-500' : 'text-neutral-400 group-hover:text-gold-500' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            <!-- Products Dropdown -->
            <div>
                <button @click="open = open === 'products' ? null : 'products'"
                    class="w-full group flex items-center justify-between px-2 py-2 text-sm font-medium rounded-md text-neutral-300 hover:bg-leather-700 hover:text-white focus:outline-none">
                    <div class="flex items-center">
                        <svg class="mr-3 flex-shrink-0 h-6 w-6 text-neutral-400 group-hover:text-gold-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Products
                    </div>
                    <svg :class="{'rotate-90': open === 'products'}"
                        class="ml-2 h-4 w-4 transform transition-transform duration-200" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="open === 'products' || '{{ request()->routeIs('admin.products.*') }}'"
                    class="space-y-1 pl-11" x-collapse>
                    <a href="{{ route('admin.products.index') }}"
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.products.index') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                        <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.products.index') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        All Products
                    </a>
                    <a href="{{ route('admin.products.create') }}"
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.products.create') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                        <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.products.create') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Product
                    </a>
                </div>
            </div>

            <!-- Categories Dropdown -->
            <div>
                <button @click="open = open === 'categories' ? null : 'categories'"
                    class="w-full group flex items-center justify-between px-2 py-2 text-sm font-medium rounded-md text-neutral-300 hover:bg-leather-700 hover:text-white focus:outline-none">
                    <div class="flex items-center">
                        <svg class="mr-3 flex-shrink-0 h-6 w-6 text-neutral-400 group-hover:text-gold-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Categories
                    </div>
                    <svg :class="{'rotate-90': open === 'categories'}"
                        class="ml-2 h-4 w-4 transform transition-transform duration-200" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="open === 'categories' || '{{ request()->routeIs('admin.categories.*') }}'"
                    class="space-y-1 pl-11" x-collapse>
                    <a href="{{ route('admin.categories.index') }}"
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.categories.index') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                        <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.categories.index') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        All Categories
                    </a>
                    <a href="{{ route('admin.categories.create') }}"
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.categories.create') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                        <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.categories.create') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Category
                    </a>
                </div>
            </div>

            <!-- Orders Dropdown -->
            <div>
                <button @click="open = open === 'orders' ? null : 'orders'"
                    class="w-full group flex items-center justify-between px-2 py-2 text-sm font-medium rounded-md text-neutral-300 hover:bg-leather-700 hover:text-white focus:outline-none">
                    <div class="flex items-center">
                        <svg class="mr-3 flex-shrink-0 h-6 w-6 text-neutral-400 group-hover:text-gold-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Orders
                    </div>
                    <svg :class="{'rotate-90': open === 'orders'}"
                        class="ml-2 h-4 w-4 transform transition-transform duration-200" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="open === 'orders' || '{{ request()->routeIs('admin.orders.*') }}'" class="space-y-1 pl-11"
                    x-collapse>
                    <a href="{{ route('admin.orders.index') }}"
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.orders.index') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                        <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.orders.index') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        All Orders
                    </a>
                </div>
            </div>



            <!-- Deals (formerly Combos) Dropdown -->
            <div>
                <button @click="open = open === 'deals' ? null : 'deals'"
                    class="w-full group flex items-center justify-between px-2 py-2 text-sm font-medium rounded-md text-neutral-300 hover:bg-leather-700 hover:text-white focus:outline-none">
                    <div class="flex items-center">
                        <svg class="mr-3 flex-shrink-0 h-6 w-6 text-neutral-400 group-hover:text-gold-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Deals
                    </div>
                    <svg :class="{'rotate-90': open === 'deals'}"
                        class="ml-2 h-4 w-4 transform transition-transform duration-200" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="open === 'deals' || '{{ request()->routeIs('admin.deals.*') }}'" class="space-y-1 pl-11"
                    x-collapse>
                    <a href="{{ route('admin.deals.index') }}"
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.deals.index') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                        <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.deals.index') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        All Deals
                    </a>
                    <a href="{{ route('admin.deals.create') }}"
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.deals.create') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                        <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.deals.create') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Deal
                    </a>
                </div>
                <!-- Coupons Dropdown -->
                <div>
                    <button @click="open = open === 'coupons' ? null : 'coupons'"
                        class="w-full group flex items-center justify-between px-2 py-2 text-sm font-medium rounded-md text-neutral-300 hover:bg-leather-700 hover:text-white focus:outline-none">
                        <div class="flex items-center">
                            <svg class="mr-3 flex-shrink-0 h-6 w-6 text-neutral-400 group-hover:text-gold-500"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Coupons
                        </div>
                        <svg :class="{'rotate-90': open === 'coupons'}"
                            class="ml-2 h-4 w-4 transform transition-transform duration-200" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 'coupons' || '{{ request()->routeIs('admin.coupons.*') }}'"
                        class="space-y-1 pl-11" x-collapse>
                        <a href="{{ route('admin.coupons.index') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.coupons.index') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                            <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.coupons.index') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            All Coupons
                        </a>
                        <a href="{{ route('admin.coupons.create') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.coupons.create') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                            <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.coupons.create') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add Coupon
                        </a>
                    </div>
                </div>

                <!-- Users Dropdown -->
                <div>
                    <button @click="open = open === 'users' ? null : 'users'"
                        class="w-full group flex items-center justify-between px-2 py-2 text-sm font-medium rounded-md text-neutral-300 hover:bg-leather-700 hover:text-white focus:outline-none">
                        <div class="flex items-center">
                            <svg class="mr-3 flex-shrink-0 h-6 w-6 text-neutral-400 group-hover:text-gold-500"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Users
                        </div>
                        <svg :class="{'rotate-90': open === 'users'}"
                            class="ml-2 h-4 w-4 transform transition-transform duration-200" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 'users' || '{{ request()->routeIs('admin.users.*') }}'"
                        class="space-y-1 pl-11" x-collapse>
                        <a href="{{ route('admin.users.index') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.users.index') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                            <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.users.index') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            All Users
                        </a>
                    </div>
                </div>

                <!-- Blogs Dropdown -->
                <div>
                    <button @click="open = open === 'blogs' ? null : 'blogs'"
                        class="w-full group flex items-center justify-between px-2 py-2 text-sm font-medium rounded-md text-neutral-300 hover:bg-leather-700 hover:text-white focus:outline-none">
                        <div class="flex items-center">
                            <svg class="mr-3 flex-shrink-0 h-6 w-6 text-neutral-400 group-hover:text-gold-500"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            Blogs
                        </div>
                        <svg :class="{'rotate-90': open === 'blogs'}"
                            class="ml-2 h-4 w-4 transform transition-transform duration-200" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 'blogs' || '{{ request()->routeIs('admin.blogs.*') || request()->routeIs('admin.blog-categories.*') }}'"
                        class="space-y-1 pl-11" x-collapse>
                        <a href="{{ route('admin.blogs.index') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.blogs.index') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                            <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.blogs.index') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            All Posts
                        </a>
                        <a href="{{ route('admin.blogs.create') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.blogs.create') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                            <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.blogs.create') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add New Post
                        </a>
                        <a href="{{ route('admin.blog-categories.index') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.blog-categories.*') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                            <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.blog-categories.*') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Categories
                        </a>
                    </div>
                </div>

                <!-- Pages -->
                <a href="{{ route('admin.pages.index') }}"
                    class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.pages.*') ? 'bg-leather-800 text-white' : 'text-neutral-300 hover:bg-leather-700 hover:text-white' }}">
                    <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('admin.pages.*') ? 'text-gold-500' : 'text-neutral-400 group-hover:text-gold-500' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Pages
                </a>

                <!-- Media Library -->
                <a href="{{ route('admin.media.index') }}"
                    class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.media.*') ? 'bg-leather-800 text-white' : 'text-neutral-300 hover:bg-leather-700 hover:text-white' }}">
                    <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('admin.media.*') ? 'text-gold-500' : 'text-neutral-400 group-hover:text-gold-500' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Media Library
                </a>

                <!-- Reports Dropdown -->
                <div>
                    <button @click="open = open === 'reports' ? null : 'reports'"
                        class="w-full group flex items-center justify-between px-2 py-2 text-sm font-medium rounded-md text-neutral-300 hover:bg-leather-700 hover:text-white focus:outline-none">
                        <div class="flex items-center">
                            <svg class="mr-3 flex-shrink-0 h-6 w-6 text-neutral-400 group-hover:text-gold-500"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Reports
                        </div>
                        <svg :class="{'rotate-90': open === 'reports'}"
                            class="ml-2 h-4 w-4 transform transition-transform duration-200" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 'reports' || '{{ request()->routeIs('admin.reports.*') }}'"
                        class="space-y-1 pl-11" x-collapse>
                        <a href="{{ route('admin.reports.inventory') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.reports.inventory') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                            <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.reports.inventory') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Inventory Report
                        </a>
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div>
                    <button @click="open = open === 'settings' ? null : 'settings'"
                        class="w-full group flex items-center justify-between px-2 py-2 text-sm font-medium rounded-md text-neutral-300 hover:bg-leather-700 hover:text-white focus:outline-none">
                        <div class="flex items-center">
                            <svg class="mr-3 flex-shrink-0 h-6 w-6 text-neutral-400 group-hover:text-gold-500"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Settings
                        </div>
                        <svg :class="{'rotate-90': open === 'settings'}"
                            class="ml-2 h-4 w-4 transform transition-transform duration-200" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 'settings' || '{{ request()->routeIs('admin.settings.*') || request()->routeIs('admin.email-templates.*') || request()->routeIs('admin.shipping-rules.*') || request()->routeIs('admin.sitemap.*') || request()->routeIs('admin.cache.*') || request()->routeIs('admin.redirects.*') }}'"
                        class="space-y-1 pl-11" x-collapse>
                        <a href="{{ route('admin.settings.index') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.settings.index') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                            <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.settings.index') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            General Settings
                        </a>
                        <a href="{{ route('admin.email-templates.index') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.email-templates.index') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                            <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.email-templates.index') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Email Templates
                        </a>
                        <a href="{{ route('admin.shipping-rules.index') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.shipping-rules.*') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                            <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.shipping-rules.*') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            Shipping Rules
                        </a>
                        <a href="{{ route('admin.sitemap.index') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.sitemap.index') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                            <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.sitemap.index') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            Sitemap
                        </a>
                        <!-- Redirects -->
                        <a href="{{ route('admin.redirects.index') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.redirects.*') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                            <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.redirects.*') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            Redirects
                        </a>
                        <a href="{{ route('admin.cache.index') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.cache.*') ? 'text-gold-500' : 'text-neutral-400 hover:text-white' }}">
                            <svg class="mr-2 h-5 w-5 {{ request()->routeIs('admin.cache.*') ? 'text-gold-500' : 'text-neutral-500 group-hover:text-white' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Cache Management
                        </a>
                    </div>
                </div>
        </nav>
    </div>
    <div class="flex-shrink-0 flex bg-leather-800 p-4">
        <div class="flex-shrink-0 w-full group block">
            <div class="flex items-center">
                <div
                    class="inline-block h-9 w-9 rounded-full bg-leather-600 flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-white">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="text-xs font-medium text-neutral-300 group-hover:text-white hover:underline">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>