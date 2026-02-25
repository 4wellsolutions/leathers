@extends('layouts.app')

@section('meta_title', $currentCategory ? ($currentCategory->meta_title ?? $currentCategory->name . ' - Leathers.pk') : 'Shop All Products - Leathers.pk')
@section('meta_description', $currentCategory ? ($currentCategory->meta_description ?? $currentCategory->description) : 'Browse our complete collection of premium leather belts, wallets, and watches.')

@section('content')
    <div class="bg-neutral-100 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-serif font-bold text-leather-900 mb-2">
                {{ $currentCategory ? $currentCategory->name : 'Our Collection' }}
            </h1>
            <p class="text-neutral-600 text-sm">
                {{ $currentCategory ? ($currentCategory->description ?? 'Discover our premium range of handcrafted leather goods.') : 'Discover our premium range of handcrafted leather goods.' }}
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ mobileFiltersOpen: false }">
        <div class="flex flex-col md:flex-row gap-12">
            <!-- Sidebar Filters (Desktop) -->
            <div class="hidden lg:block w-64 flex-shrink-0">
                <div class="sticky top-24">
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-leather-900 mb-4 border-b border-neutral-200 pb-2">Categories</h3>
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('home') }}#categories"
                                    class="flex items-center justify-between group {{ !$currentCategory ? 'text-gold-600 font-semibold' : 'text-neutral-600 hover:text-leather-900' }}">
                                    <span>All Products</span>
                                    <span
                                        class="bg-neutral-100 text-xs px-2 py-1 rounded-full group-hover:bg-gold-100 transition-colors">
                                        {{ \App\Models\Product::where('is_active', true)->count() }}
                                    </span>
                                </a>
                            </li>
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('category.show', $category->slug) }}"
                                        class="flex items-center justify-between group {{ $currentCategory && $currentCategory->id == $category->id ? 'text-gold-600 font-semibold' : 'text-neutral-600 hover:text-leather-900' }}">
                                        <span>{{ $category->name }}</span>
                                        <span
                                            class="bg-neutral-100 text-xs px-2 py-1 rounded-full group-hover:bg-gold-100 transition-colors">
                                            {{ $category->products()->where('is_active', true)->count() }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-leather-900 mb-4 border-b border-neutral-200 pb-2">Price Range
                        </h3>
                        <form id="priceFilterForm">
                            <div class="space-y-2">
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="price_range[]" value="under_5000"
                                        class="price-filter form-checkbox text-gold-500 rounded border-neutral-300 focus:ring-gold-500"
                                        {{ in_array('under_5000', request('price_range', [])) ? 'checked' : '' }}>
                                    <span class="text-neutral-600">Under Rs. 5,000</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="price_range[]" value="5000_10000"
                                        class="price-filter form-checkbox text-gold-500 rounded border-neutral-300 focus:ring-gold-500"
                                        {{ in_array('5000_10000', request('price_range', [])) ? 'checked' : '' }}>
                                    <span class="text-neutral-600">Rs. 5,000 - Rs. 10,000</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="price_range[]" value="over_10000"
                                        class="price-filter form-checkbox text-gold-500 rounded border-neutral-300 focus:ring-gold-500"
                                        {{ in_array('over_10000', request('price_range', [])) ? 'checked' : '' }}>
                                    <span class="text-neutral-600">Over Rs. 10,000</span>
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Product Grid -->
            <div class="flex-1">
                <!-- Toolbar: Sort and View Toggle -->
                <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center justify-between w-full sm:w-auto gap-4">
                        <!-- Mobile Filter Trigger -->
                        <button @click="mobileFiltersOpen = true"
                            class="lg:hidden flex items-center px-4 py-2 border border-neutral-300 rounded-lg bg-white text-neutral-700 hover:bg-neutral-50 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filters
                        </button>

                        <p class="text-neutral-600">
                            {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- View Toggle -->
                        <div class="flex items-center space-x-2 border border-neutral-300 rounded-lg p-1">
                            <button id="gridViewBtn" class="view-toggle-btn active px-3 py-2 rounded transition-colors"
                                data-view="grid">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                            </button>
                            <button id="listViewBtn" class="view-toggle-btn px-3 py-2 rounded transition-colors"
                                data-view="list">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>

                        <!-- Sort Dropdown -->
                        <div class="flex items-center space-x-2">
                            <label for="sort" class="text-sm text-neutral-600">Sort:</label>
                            <select id="sort" name="sort"
                                class="border border-neutral-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-gold-500 focus:border-gold-500">
                                <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Latest</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to
                                    High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High
                                    to Low</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                @if($products->count() > 0)
                    <!-- Grid View -->
                    <div id="gridView" class="grid grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <!-- List View -->
                    <div id="listView" class="hidden space-y-4">
                        @foreach($products as $product)
                            <x-product-list-item :product="$product" />
                        @endforeach
                    </div>

                    <div class="mt-12">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-20">
                        <div class="inline-block p-6 rounded-full bg-neutral-100 text-neutral-400 mb-4">
                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-leather-900 mb-2">No products found</h3>
                        <p class="text-neutral-600 mb-6">Try adjusting your filters or check back later for new arrivals.</p>
                        <a href="{{ route('home') }}" class="btn-primary">Clear Filters</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Mobile Filter Drawer (Off-Canvas) -->
        <div class="relative z-50 lg:hidden" x-show="mobileFiltersOpen" role="dialog" aria-modal="true"
            style="display: none;">
            <div x-show="mobileFiltersOpen" x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black bg-opacity-25" aria-hidden="true"
                @click="mobileFiltersOpen = false"></div>

            <div class="fixed inset-0 flex z-40">
                <div x-show="mobileFiltersOpen" x-transition:enter="transition ease-in-out duration-300 transform"
                    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in-out duration-300 transform"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                    class="relative max-w-xs w-full bg-white shadow-xl py-4 pb-12 flex flex-col overflow-y-auto h-full">
                    <div class="px-4 flex items-center justify-between mb-4 border-b border-neutral-200 pb-4">
                        <h2 class="text-lg font-medium text-leather-900">Filters</h2>
                        <button type="button"
                            class="-mr-2 w-10 h-10 bg-white p-2 rounded-md flex items-center justify-center text-neutral-400"
                            @click="mobileFiltersOpen = false">
                            <span class="sr-only">Close menu</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Filters -->
                    <div class="px-4">
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-leather-900 mb-4 border-b border-neutral-200 pb-2">Categories
                            </h3>
                            <ul class="space-y-3">
                                <li>
                                    <a href="{{ route('home') }}#categories"
                                        class="flex items-center justify-between group {{ !$currentCategory ? 'text-gold-600 font-semibold' : 'text-neutral-600 hover:text-leather-900' }}">
                                        <span>All Products</span>
                                        <span
                                            class="bg-neutral-100 text-xs px-2 py-1 rounded-full group-hover:bg-gold-100 transition-colors">
                                            {{ \App\Models\Product::where('is_active', true)->count() }}
                                        </span>
                                    </a>
                                </li>
                                @foreach($categories as $category)
                                    <li>
                                        <a href="{{ route('category.show', $category->slug) }}"
                                            class="flex items-center justify-between group {{ $currentCategory && $currentCategory->id == $category->id ? 'text-gold-600 font-semibold' : 'text-neutral-600 hover:text-leather-900' }}">
                                            <span>{{ $category->name }}</span>
                                            <span
                                                class="bg-neutral-100 text-xs px-2 py-1 rounded-full group-hover:bg-gold-100 transition-colors">
                                                {{ $category->products()->where('is_active', true)->count() }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-leather-900 mb-4 border-b border-neutral-200 pb-2">Price Range
                            </h3>
                            <form id="mobilePriceFilterForm">
                                <div class="space-y-2">
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="checkbox" name="price_range[]" value="under_5000"
                                            class="price-filter form-checkbox text-gold-500 rounded border-neutral-300 focus:ring-gold-500"
                                            {{ in_array('under_5000', request('price_range', [])) ? 'checked' : '' }}>
                                        <span class="text-neutral-600">Under Rs. 5,000</span>
                                    </label>
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="checkbox" name="price_range[]" value="5000_10000"
                                            class="price-filter form-checkbox text-gold-500 rounded border-neutral-300 focus:ring-gold-500"
                                            {{ in_array('5000_10000', request('price_range', [])) ? 'checked' : '' }}>
                                        <span class="text-neutral-600">Rs. 5,000 - Rs. 10,000</span>
                                    </label>
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="checkbox" name="price_range[]" value="over_10000"
                                            class="price-filter form-checkbox text-gold-500 rounded border-neutral-300 focus:ring-gold-500"
                                            {{ in_array('over_10000', request('price_range', [])) ? 'checked' : '' }}>
                                        <span class="text-neutral-600">Over Rs. 10,000</span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CollectionPage Schema -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "CollectionPage",
            "name": "{{ $currentCategory ? $currentCategory->name : 'All Products' }}",
            "description": "{{ Str::limit(strip_tags($currentCategory ? ($currentCategory->description ?? '') : 'Browse our collection of premium leather goods.'), 200) }}",
            "url": "{{ url()->current() }}",
            "breadcrumb": {
                "@type": "BreadcrumbList",
                "itemListElement": [
                    {
                        "@type": "ListItem",
                        "position": 1,
                        "name": "Home",
                        "item": "{{ route('home') }}"
                    },
                    {
                        "@type": "ListItem",
                        "position": 2,
                        "name": "Shop",
                        "item": "{{ route('home') }}#categories"
                    }
                    @if($currentCategory)
                        ,{
                            "@type": "ListItem",
                            "position": 3,
                            "name": "{{ $currentCategory->name }}",
                            "item": "{{ route('category.show', $currentCategory->slug) }}"
                        }
                    @endif
                ]
            }
        }
        </script>

    <script>
        // Price filter functionality
        // Price filter functionality
        document.addEventListener('DOMContentLoaded', function () {
            // Function to handle price filtering
            function handlePriceFilter(formId) {
                const form = document.getElementById(formId);
                if (!form) return;

                const formData = new FormData(form);
                const url = new URL(window.location.href);

                // Remove existing price_range parameters
                url.searchParams.delete('price_range[]');
                url.searchParams.delete('price_range');

                // Add selected price ranges
                const selectedRanges = formData.getAll('price_range[]');
                selectedRanges.forEach(range => {
                    url.searchParams.append('price_range[]', range);
                });

                // Reset to page 1 when filtering
                url.searchParams.delete('page');

                // Redirect to new URL
                window.location.href = url.toString();
            }

            // Attach listeners to both desktop and mobile forms
            ['priceFilterForm', 'mobilePriceFilterForm'].forEach(formId => {
                const form = document.getElementById(formId);
                if (form) {
                    const checkboxes = form.querySelectorAll('.price-filter');
                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', () => handlePriceFilter(formId));
                    });
                }
            });
        });
    </script>

    <script>
        // Sort dropdown functionality
        document.addEventListener('DOMContentLoaded', function () {
            const sortSelect = document.getElementById('sort');

            if (sortSelect) {
                sortSelect.addEventListener('change', function () {
                    const url = new URL(window.location.href);

                    // Update sort parameter
                    if (this.value && this.value !== 'latest') {
                        url.searchParams.set('sort', this.value);
                    } else {
                        url.searchParams.delete('sort');
                    }

                    // Reset to page 1 when sorting
                    url.searchParams.delete('page');

                    // Redirect to new URL
                    window.location.href = url.toString();
                });
            }
        });
    </script>

    <script>
        // View toggle functionality
        document.addEventListener('DOMContentLoaded', function () {
            const gridViewBtn = document.getElementById('gridViewBtn');
            const listViewBtn = document.getElementById('listViewBtn');
            const gridView = document.getElementById('gridView');
            const listView = document.getElementById('listView');

            if (gridViewBtn && listViewBtn && gridView && listView) {
                function setActiveView(view) {
                    if (view === 'grid') {
                        gridView.classList.remove('hidden');
                        listView.classList.add('hidden');
                        gridViewBtn.classList.add('active', 'text-gold-600', 'bg-gold-50', 'border-gold-500');
                        gridViewBtn.classList.remove('text-neutral-400');

                        listViewBtn.classList.remove('active', 'text-gold-600', 'bg-gold-50', 'border-gold-500');
                        listViewBtn.classList.add('text-neutral-400');
                    } else {
                        gridView.classList.add('hidden');
                        listView.classList.remove('hidden');
                        listViewBtn.classList.add('active', 'text-gold-600', 'bg-gold-50', 'border-gold-500');
                        listViewBtn.classList.remove('text-neutral-400');

                        gridViewBtn.classList.remove('active', 'text-gold-600', 'bg-gold-50', 'border-gold-500');
                        gridViewBtn.classList.add('text-neutral-400');
                    }
                    localStorage.setItem('productView', view);
                }

                gridViewBtn.addEventListener('click', () => setActiveView('grid'));
                listViewBtn.addEventListener('click', () => setActiveView('list'));

                // Initialize based on saved preference or default
                const savedView = localStorage.getItem('productView');
                if (savedView === 'list') {
                    setActiveView('list');
                } else {
                    // Default styles for grid button if no preference
                    gridViewBtn.classList.add('text-gold-600', 'bg-gold-50', 'border-gold-500');
                }
            }
        });
    </script>
@endsection