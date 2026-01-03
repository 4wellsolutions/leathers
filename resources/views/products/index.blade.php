@extends('layouts.app')

@section('meta_title', $currentCategory ? ($currentCategory->meta_title ?? $currentCategory->name . ' - Leathers.pk') : 'Shop All Products - Leathers.pk')
@section('meta_description', $currentCategory ? ($currentCategory->meta_description ?? $currentCategory->description) : 'Browse our complete collection of premium leather belts, wallets, and watches.')

@section('content')
    <div class="bg-neutral-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-serif font-bold text-leather-900 mb-2">Our Collection</h1>
            <p class="text-neutral-600">Discover our premium range of handcrafted leather goods.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col md:flex-row gap-12">
            <!-- Sidebar Filters -->
            <div class="w-full md:w-64 flex-shrink-0">
                <div class="sticky top-24">
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-leather-900 mb-4 border-b border-neutral-200 pb-2">Categories</h3>
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('products.index') }}"
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
                    <p class="text-neutral-600">
                        Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of
                        {{ $products->total() }} products
                    </p>
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
                    <div id="gridView" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
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
                        <a href="{{ route('products.index') }}" class="btn-primary">Clear Filters</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- CollectionPage Schema -->
    <script type="application/ld+json">
            {
              "@@context": "https://schema.org",
              "@@type": "CollectionPage",
              "name": "{{ $currentCategory ? $currentCategory->name : 'All Products' }}",
              "description": "{{ $currentCategory ? $currentCategory->description : 'Browse our collection of premium leather goods.' }}",
              "url": "{{ url()->current() }}",
              "breadcrumb": {
                "@@type": "BreadcrumbList",
                "itemListElement": [
                  {
                    "@@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": "{{ route('home') }}"
                  },
                  {
                    "@@type": "ListItem",
                    "position": 2,
                    "name": "Shop",
                    "item": "{{ route('products.index') }}"
                  }
                  @if($currentCategory)
                      ,{
                        "@@type": "ListItem",
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
        document.addEventListener('DOMContentLoaded', function () {
            const priceFilters = document.querySelectorAll('.price-filter');

            priceFilters.forEach(filter => {
                filter.addEventListener('change', function () {
                    const form = document.getElementById('priceFilterForm');
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
                });
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