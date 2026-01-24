@extends('layouts.admin')

@section('title', 'Create New Deal')

@section('content')
    <div class="max-w-5xl mx-auto py-8">
        <form action="{{ route('admin.deals.store') }}" method="POST" class="space-y-8" id="deal-form">
            @csrf

            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Create New Deal</h1>
                    <p class="mt-1 text-sm text-gray-500">Combine products into a single attractive offer.</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.deals.index') }}"
                        class="bg-white py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-gold-600 hover:bg-gold-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-colors">
                        Create Deal
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Info Column -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Basic Details Card -->
                    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="text-base font-semibold text-gray-900">Basic Information</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Deal Name <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm transition-shadow"
                                    placeholder="e.g. Summer Essentials Pack" required>
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug <span
                                        class="text-red-500">*</span></label>
                                <div class="relative rounded-md shadow-sm">
                                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm bg-gray-50 text-gray-500"
                                        readonly required>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Auto-generated from name.</p>
                            </div>

                            <div>
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea id="description" name="description" rows="4"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm"
                                    placeholder="Describe what makes this deal special...">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Products Selection Card -->
                    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                            <h3 class="text-base font-semibold text-gray-900">Deal Items</h3>
                            <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700">Select at
                                least 2 items</span>
                        </div>
                        <div class="p-6">
                            <!-- Search -->
                            <div class="relative mb-8">
                                <label for="product-search" class="block text-sm font-medium text-gray-700 mb-1">Add
                                    Products</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="product-search"
                                        class="block w-full pl-12 pr-3 py-2.5 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-gold-500 focus:border-gold-500 sm:text-sm transition duration-150 ease-in-out shadow-sm"
                                        placeholder="Search by name, SKU, or category...">
                                </div>

                                <!-- Search Results Dropdown -->
                                <div id="search-results"
                                    class="absolute z-20 mt-1 w-full bg-white shadow-lg max-h-60 rounded-lg py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm hidden divide-y divide-gray-100">
                                    <!-- Results populated by JS -->
                                </div>
                            </div>

                            <!-- Selected Products List -->
                            <div id="selected-products-container" class="space-y-4">
                                <!-- Product cards populated by JS -->
                            </div>

                            <div id="empty-state"
                                class="text-center py-12 px-4 border-2 border-dashed border-gray-200 rounded-lg">
                                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No products added</h3>
                                <p class="mt-1 text-sm text-gray-500">Search for products above to add them to this deal.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- Pricing Card -->
                    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="text-base font-semibold text-gray-900">Pricing & Schedule</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Deal Price (Rs)
                                    <span class="text-red-500">*</span></label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rs.</span>
                                    </div>
                                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01"
                                        class="block w-full pl-10 pr-12 rounded-lg border-gray-300 focus:border-gold-500 focus:ring-gold-500 sm:text-sm font-semibold text-gray-900"
                                        placeholder="0.00" required>
                                </div>
                            </div>

                            <hr class="border-gray-100">

                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start
                                    Date</label>
                                <input type="datetime-local" name="start_date" id="start_date"
                                    value="{{ old('start_date') }}"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm text-gray-600">
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm text-gray-600">
                            </div>

                            <hr class="border-gray-100">

                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                        class="focus:ring-gold-500 h-4 w-4 text-gold-600 border-gray-300 rounded transition-colors">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_active" class="font-medium text-gray-900">Active Status</label>
                                    <p class="text-gray-500 text-xs">Visible on frontend</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity" onclick="closeImageModal()"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative transform overflow-hidden rounded-xl bg-white shadow-2xl transition-all max-w-2xl w-full">
                    <button type="button"
                        class="absolute right-4 top-4 text-gray-400 hover:text-gray-500 focus:outline-none"
                        onclick="closeImageModal()">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="p-2 flex justify-center bg-gray-50">
                        <img id="modalImage" src="" alt="Product Image"
                            class="max-h-[80vh] w-auto rounded-lg object-contain">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // State
            const addedProductIds = new Set();
            const emptyState = document.getElementById('empty-state');
            const searchInput = document.getElementById('product-search');
            const resultsContainer = document.getElementById('search-results');
            const selectedContainer = document.getElementById('selected-products-container');

            // Image Modal Logic
            function openImageModal(imageUrl) {
                document.getElementById('modalImage').src = imageUrl;
                document.getElementById('imageModal').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeImageModal() {
                document.getElementById('imageModal').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            // Initialization
            document.addEventListener('DOMContentLoaded', function () {
                // Slug Generation
                const nameInput = document.getElementById('name');
                const slugInput = document.getElementById('slug');

                if (nameInput && slugInput) {
                    nameInput.addEventListener('input', function (e) {
                        const slug = e.target.value
                            .toLowerCase()
                            .replace(/[^a-z0-9]+/g, '-')
                            .replace(/^-+|-+$/g, '');
                        slugInput.value = slug;
                    });
                }

                // Search Logic
                let debounceTimer;

                searchInput.addEventListener('input', function (e) {
                    clearTimeout(debounceTimer);
                    const query = e.target.value.trim();

                    if (query.length < 2) {
                        resultsContainer.classList.add('hidden');
                        return;
                    }

                    debounceTimer = setTimeout(() => {
                        fetch(`{{ route('admin.deals.search-products') }}?q=${query}`)
                            .then(response => response.json())
                            .then(products => {
                                resultsContainer.innerHTML = '';
                                if (products.length > 0) {
                                    products.forEach(product => {
                                        if (addedProductIds.has(product.id)) return;

                                        const div = document.createElement('div');
                                        div.className = 'cursor-pointer px-4 py-3 hover:bg-gray-50 flex items-center transition-colors border-b border-gray-50 last:border-0';
                                        div.innerHTML = `
                                                                            <div class="h-10 w-10 flex-shrink-0 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden">
                                                                                <img src="${product.image_url}" class="h-full w-full object-cover">
                                                                            </div>
                                                                            <div class="ml-3 flex-1 min-w-0">
                                                                                <p class="text-sm font-medium text-gray-900 truncate">${product.name}</p>
                                                                                <p class="text-xs text-gray-500">${product.variants ? product.variants.length : 0} variants</p>
                                                                            </div>
                                                                            <div class="ml-auto">
                                                                                 <svg class="h-5 w-5 text-gray-400 group-hover:text-gold-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                                                </svg>
                                                                            </div>
                                                                        `;
                                        div.addEventListener('click', () => {
                                            addProduct(product);
                                            searchInput.value = '';
                                            resultsContainer.classList.add('hidden');
                                        });
                                        resultsContainer.appendChild(div);
                                    });

                                    if (resultsContainer.children.length === 0) {
                                        resultsContainer.innerHTML = '<div class="px-4 py-3 text-sm text-gray-500">All matching products already added.</div>';
                                    }
                                    resultsContainer.classList.remove('hidden');
                                } else {
                                    resultsContainer.innerHTML = '<div class="px-4 py-3 text-sm text-gray-500">No products found.</div>';
                                    resultsContainer.classList.remove('hidden');
                                }
                            });
                    }, 300);
                });

                // Close search on outside click
                document.addEventListener('click', function (e) {
                    if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                        resultsContainer.classList.add('hidden');
                    }
                });
            });

            // Add Product to List
            function addProduct(product) {
                if (addedProductIds.has(product.id)) return;
                addedProductIds.add(product.id);

                updateEmptyState();

                const productEl = document.createElement('div');
                productEl.className = 'bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200';
                productEl.id = `product-card-${product.id}`;

                let variantsHtml = '';
                if (product.variants && product.variants.length > 0) {
                    product.variants.forEach(variant => {
                        const isOutOfStock = variant.stock <= 0;
                        const price = variant.price || product.price;

                        // variant badges
                        const badges = [];
                        if (variant.color) badges.push(`<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200"><span class="w-2.5 h-2.5 rounded-full border border-gray-300" style="background-color: ${variant.color.hex_code}"></span>${variant.color.name}</span>`);
                        if (variant.size) badges.push(`<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">Size: ${variant.size}</span>`);
                        if (isOutOfStock) badges.push(`<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-red-50 text-red-700 border border-red-200">OUT OF STOCK</span>`);

                        // stock class
                        const stockTextClass = isOutOfStock ? 'text-red-600 font-medium' : 'text-green-600 font-medium';
                        const rowOpacity = isOutOfStock ? 'opacity-60 bg-gray-50' : 'hover:bg-gray-50';

                        variantsHtml += `
                                                            <div class="px-4 py-3 border-t border-gray-100 transition-colors ${rowOpacity}">
                                                                <div class="flex items-center gap-4">
                                                                    <!-- Checkbox -->
                                                                    <div class="flex items-center h-5">
                                                                        <input id="variant_${variant.id}" 
                                                                            name="variants[]" 
                                                                            value="${variant.id}"
                                                                            type="checkbox"
                                                                            ${isOutOfStock ? 'disabled' : ''}
                                                                            class="h-4 w-4 text-gold-600 border-gray-300 rounded focus:ring-gold-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                                                    </div>

                                                                    <!-- Info -->
                                                                    <label for="variant_${variant.id}" class="flex-1 flex items-center justify-between cursor-pointer ${isOutOfStock ? 'cursor-not-allowed' : ''}">
                                                                        <div class="min-w-0">
                                                                            <div class="flex items-center gap-2 mb-1 flex-wrap">
                                                                                ${variant.name ? `<span class="text-sm font-medium text-gray-900">${variant.name}</span>` : ''}
                                                                                ${badges.join('')}
                                                                            </div>
                                                                            <div class="flex items-center gap-4 text-xs text-gray-500">
                                                                                <span>SKU: <span class="font-mono text-gray-700">${variant.sku || 'N/A'}</span></span>
                                                                                <span>Stock: <span class="${stockTextClass}">${variant.stock}</span></span>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Price -->
                                                                        <div class="text-right mx-4">
                                                                            <span class="block text-sm font-semibold text-gray-900">Rs. ${parseFloat(price).toLocaleString()}</span>
                                                                        </div>
                                                                    </label>

                                                                    <!-- Quantity -->
                                                                    <div class="w-24">
                                                                        <label for="quantity_${variant.id}" class="sr-only">Quantity</label>
                                                                        <div class="relative rounded-md shadow-sm">
                                                                            <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                                                               <span class="text-xs text-gray-400">Qty</span>
                                                                            </div>
                                                                            <input type="number" 
                                                                                name="quantities[${variant.id}]" 
                                                                                id="quantity_${variant.id}"
                                                                                value="1" 
                                                                                min="1"
                                                                                ${!isOutOfStock ? `max="${variant.stock}"` : ''}
                                                                                ${isOutOfStock ? 'disabled' : ''}
                                                                                class="block w-full pl-12 rounded-md border-gray-300 focus:border-gold-500 focus:ring-gold-500 sm:text-sm disabled:bg-gray-100 disabled:text-gray-400">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        `;
                    });
                } else {
                    variantsHtml = `
                                                        <div class="px-6 py-8 text-center bg-gray-50 border-t border-gray-100">
                                                            <p class="text-sm text-gray-500 italic">This product has no variants configured.</p>
                                                        </div>`;
                }

                productEl.innerHTML = `
                                                    <!-- Product Header -->
                                                    <div class="px-4 py-3 bg-white flex items-center justify-between">
                                                        <div class="flex items-center gap-3">
                                                            <div class="relative group cursor-pointer h-12 w-12 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden" onclick="openImageModal('${product.image_url}')">
                                                                <img src="${product.image_url}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">
                                                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors"></div>
                                                            </div>
                                                            <div>
                                                                <h4 class="text-sm font-bold text-gray-900">${product.name}</h4>
                                                                <p class="text-xs text-gray-500">${product.variants ? product.variants.length : 0} variants available</p>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="text-gray-400 hover:text-red-600 transition-colors p-2 rounded-lg hover:bg-red-50" onclick="removeProduct(${product.id})" title="Remove Product">
                                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <!-- Variants List -->
                                                    <div class="bg-white">
                                                        ${variantsHtml}
                                                    </div>
                                                `;

                selectedContainer.appendChild(productEl);
            }

            function removeProduct(productId) {
                const el = document.getElementById(`product-card-${productId}`);
                if (el) {
                    el.remove();
                    addedProductIds.delete(productId);
                }
                updateEmptyState();
            }

            function updateEmptyState() {
                if (addedProductIds.size === 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            }
        </script>
    @endpush
@endsection