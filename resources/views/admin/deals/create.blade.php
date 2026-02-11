@extends('layouts.admin')

@section('title', 'Create New Deal')

@section('content')
    <div class="max-w-5xl mx-auto py-8">
        <form action="{{ route('admin.deals.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8" id="deal-form">
            @csrf

            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-leather-900">Create New Deal</h1>
                    <p class="mt-1 text-sm text-neutral-500">Combine products into a single attractive offer.</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.deals.index') }}"
                        class="bg-white py-2.5 px-5 border border-neutral-300 rounded-xl shadow-sm text-sm font-medium text-neutral-700 hover:bg-neutral-50 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center py-2.5 px-6 border border-transparent shadow-sm text-sm font-semibold rounded-xl text-white bg-gold-600 hover:bg-gold-700 transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Create Deal
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Info Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Details Card -->
                    <div class="bg-white shadow-sm rounded-xl border border-neutral-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-neutral-100 bg-neutral-50/50">
                            <h3 class="text-sm font-semibold text-leather-900 uppercase tracking-wider">Basic Information</h3>
                        </div>
                        <div class="p-6 space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-neutral-700 mb-1.5">Deal Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm"
                                        placeholder="e.g. Summer Essentials Pack" required>
                                </div>
                                <div>
                                    <label for="slug" class="block text-sm font-medium text-neutral-700 mb-1.5">Slug <span class="text-red-500">*</span></label>
                                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                                        class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm bg-neutral-50 text-neutral-500"
                                        readonly required>
                                    <p class="mt-1 text-xs text-neutral-400">Auto-generated from name</p>
                                </div>
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium text-neutral-700 mb-1.5">Description</label>
                                <textarea id="description" name="description" rows="3"
                                    class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm"
                                    placeholder="Describe what makes this deal special...">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Products Selection Card -->
                    <div class="bg-white shadow-sm rounded-xl border border-neutral-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-neutral-100 bg-neutral-50/50 flex justify-between items-center">
                            <h3 class="text-sm font-semibold text-leather-900 uppercase tracking-wider">Deal Items</h3>
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20">Min 2 items</span>
                        </div>
                        <div class="p-6">
                            <!-- Search -->
                            <div class="relative mb-6" id="product-search-wrap">
                                <label for="product-search" class="block text-sm font-medium text-neutral-700 mb-1.5">Add Products</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" id="product-search"
                                        class="block w-full pl-10 pr-3 py-2.5 border border-neutral-300 rounded-lg bg-white placeholder-neutral-400 focus:outline-none focus:ring-1 focus:ring-gold-500 focus:border-gold-500 sm:text-sm shadow-sm"
                                        placeholder="Search by name or slug..." autocomplete="off">
                                </div>

                                <!-- Search Results Dropdown -->
                                <div id="search-results"
                                    class="absolute z-20 mt-1 w-full bg-white shadow-lg max-h-72 rounded-xl text-base ring-1 ring-neutral-200 overflow-auto focus:outline-none sm:text-sm hidden">
                                </div>
                            </div>

                            <!-- Selected Products List -->
                            <div id="selected-products-container" class="space-y-4"></div>

                            <div id="empty-state"
                                class="text-center py-12 px-4 border-2 border-dashed border-neutral-200 rounded-xl bg-neutral-50/50">
                                <div class="w-14 h-14 bg-neutral-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="h-7 w-7 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-neutral-700">No products added</h3>
                                <p class="mt-1 text-xs text-neutral-400">Search for products above to add them to this deal.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Deal Image Card -->
                    <div class="bg-white shadow-sm rounded-xl border border-neutral-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-neutral-100 bg-neutral-50/50">
                            <h3 class="text-sm font-semibold text-leather-900 uppercase tracking-wider">Deal Image</h3>
                        </div>
                        <div class="p-6">
                            <div id="image-upload-area"
                                class="relative border-2 border-dashed border-neutral-300 rounded-xl overflow-hidden hover:border-gold-500 transition-colors cursor-pointer bg-neutral-50"
                                onclick="document.getElementById('deal-image-input').click()">
                                <!-- Preview -->
                                <div id="image-preview" class="hidden">
                                    <img id="image-preview-img" src="" class="w-full h-48 object-cover" alt="Deal image preview">
                                    <button type="button" id="remove-image-btn"
                                        class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-7 h-7 flex items-center justify-center shadow-lg transition" onclick="event.stopPropagation(); removeImage();">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                                <!-- Upload placeholder -->
                                <div id="image-placeholder" class="py-10 text-center">
                                    <svg class="mx-auto h-10 w-10 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="mt-2 text-sm font-medium text-neutral-600">Click to upload</p>
                                    <p class="text-xs text-neutral-400">PNG, JPG, WEBP up to 2MB</p>
                                </div>
                            </div>
                            <input type="file" id="deal-image-input" name="image" accept="image/*" class="hidden">
                            @error('image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Pricing Card -->
                    <div class="bg-white shadow-sm rounded-xl border border-neutral-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-neutral-100 bg-neutral-50/50">
                            <h3 class="text-sm font-semibold text-leather-900 uppercase tracking-wider">Pricing & Schedule</h3>
                        </div>
                        <div class="p-6 space-y-5">
                            <div>
                                <label for="price" class="block text-sm font-medium text-neutral-700 mb-1.5">Deal Price (Rs) <span class="text-red-500">*</span></label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <span class="text-neutral-500 sm:text-sm font-medium">Rs.</span>
                                    </div>
                                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01"
                                        class="block w-full pl-12 rounded-lg border-neutral-300 focus:border-gold-500 focus:ring-gold-500 sm:text-sm font-semibold text-leather-900"
                                        placeholder="0.00" required>
                                </div>
                            </div>

                            <hr class="border-neutral-100">

                            <div>
                                <label for="start_date" class="block text-sm font-medium text-neutral-700 mb-1.5">Start Date</label>
                                <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                    class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm text-neutral-600">
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-neutral-700 mb-1.5">End Date</label>
                                <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                    class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm text-neutral-600">
                            </div>

                            <hr class="border-neutral-100">

                            <div class="flex items-center justify-between p-3 bg-neutral-50 rounded-lg">
                                <div>
                                    <label for="is_active" class="text-sm font-medium text-neutral-900 cursor-pointer">Active Status</label>
                                    <p class="text-xs text-neutral-500">Visible on frontend</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div class="w-9 h-5 bg-neutral-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-gold-600"></div>
                                </label>
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
                <div class="relative transform overflow-hidden rounded-xl bg-white shadow-2xl transition-all max-w-2xl w-full">
                    <button type="button" class="absolute right-4 top-4 text-gray-400 hover:text-gray-500 focus:outline-none z-10" onclick="closeImageModal()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                    <div class="p-2 flex justify-center bg-gray-50">
                        <img id="modalImage" src="" alt="Product Image" class="max-h-[80vh] w-auto rounded-lg object-contain">
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

            // Deal Image Upload Preview
            document.addEventListener('DOMContentLoaded', function () {
                const imageInput = document.getElementById('deal-image-input');
                const previewContainer = document.getElementById('image-preview');
                const previewImg = document.getElementById('image-preview-img');
                const placeholder = document.getElementById('image-placeholder');

                if (imageInput) {
                    imageInput.addEventListener('change', function () {
                        if (this.files && this.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                previewImg.src = e.target.result;
                                previewContainer.classList.remove('hidden');
                                placeholder.classList.add('hidden');
                            };
                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                }

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
                                        div.className = 'cursor-pointer px-4 py-3 hover:bg-gold-50 flex items-center transition-colors border-b border-neutral-50 last:border-0';
                                        div.innerHTML = `
                                            <div class="h-11 w-11 flex-shrink-0 rounded-lg bg-neutral-100 border border-neutral-200 overflow-hidden">
                                                <img src="${product.image_url}" class="h-full w-full object-cover" onerror="this.src='/images/placeholder.jpg'">
                                            </div>
                                            <div class="ml-3 flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-neutral-900 truncate">${product.name}</p>
                                                <p class="text-xs text-neutral-400">${product.variants ? product.variants.length : 0} variants • Rs. ${parseFloat(product.price).toLocaleString()}</p>
                                            </div>
                                            <div class="ml-3 flex-shrink-0">
                                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gold-50 text-gold-600 hover:bg-gold-100 transition">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                                </span>
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
                                        resultsContainer.innerHTML = '<div class="px-4 py-4 text-sm text-neutral-400 text-center">All matching products already added.</div>';
                                    }
                                    resultsContainer.classList.remove('hidden');
                                } else {
                                    resultsContainer.innerHTML = '<div class="px-4 py-4 text-sm text-neutral-400 text-center">No products found.</div>';
                                    resultsContainer.classList.remove('hidden');
                                }
                            });
                    }, 300);
                });

                // Close search on outside click
                document.addEventListener('click', function (e) {
                    if (!document.getElementById('product-search-wrap').contains(e.target)) {
                        resultsContainer.classList.add('hidden');
                    }
                });
            });

            // Remove deal image
            function removeImage() {
                const imageInput = document.getElementById('deal-image-input');
                const previewContainer = document.getElementById('image-preview');
                const placeholder = document.getElementById('image-placeholder');
                imageInput.value = '';
                previewContainer.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }

            // Add Product to List
            function addProduct(product) {
                if (addedProductIds.has(product.id)) return;
                addedProductIds.add(product.id);

                updateEmptyState();

                const productEl = document.createElement('div');
                productEl.className = 'bg-white border border-neutral-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200';
                productEl.id = `product-card-${product.id}`;

                let variantsHtml = '';
                if (product.variants && product.variants.length > 0) {
                    product.variants.forEach(variant => {
                        const isOutOfStock = variant.stock <= 0;
                        const price = variant.price || product.price;

                        // variant badges
                        const badges = [];
                        if (variant.color) badges.push(`<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-neutral-100 text-neutral-700"><span class="w-2.5 h-2.5 rounded-full border border-neutral-300" style="background-color: ${variant.color.hex_code}"></span>${variant.color.name}</span>`);
                        if (variant.size) badges.push(`<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-neutral-100 text-neutral-700">Size: ${variant.size}</span>`);
                        if (isOutOfStock) badges.push(`<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-red-50 text-red-600 ring-1 ring-inset ring-red-500/20">OUT OF STOCK</span>`);

                        const stockTextClass = isOutOfStock ? 'text-red-600 font-medium' : 'text-green-600 font-medium';
                        const rowOpacity = isOutOfStock ? 'opacity-50 bg-neutral-50' : 'hover:bg-neutral-50';

                        variantsHtml += `
                            <div class="px-4 py-3 border-t border-neutral-100 transition-colors ${rowOpacity}">
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center h-5">
                                        <input id="variant_${variant.id}"
                                            name="variants[]"
                                            value="${variant.id}"
                                            type="checkbox"
                                            ${isOutOfStock ? 'disabled' : ''}
                                            class="h-4 w-4 text-gold-600 border-neutral-300 rounded focus:ring-gold-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                    </div>
                                    <label for="variant_${variant.id}" class="flex-1 flex items-center justify-between cursor-pointer ${isOutOfStock ? 'cursor-not-allowed' : ''}">
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-1.5 mb-1 flex-wrap">
                                                ${variant.name ? `<span class="text-sm font-medium text-neutral-900">${variant.name}</span>` : ''}
                                                ${badges.join('')}
                                            </div>
                                            <div class="flex items-center gap-3 text-xs text-neutral-500">
                                                <span>SKU: <span class="font-mono text-neutral-600">${variant.sku || 'N/A'}</span></span>
                                                <span>Stock: <span class="${stockTextClass}">${variant.stock}</span></span>
                                            </div>
                                        </div>
                                        <div class="text-right mx-4">
                                            <span class="block text-sm font-bold text-leather-900">Rs. ${parseFloat(price).toLocaleString()}</span>
                                        </div>
                                    </label>
                                    <div class="w-20">
                                        <label for="quantity_${variant.id}" class="sr-only">Quantity</label>
                                        <div class="relative rounded-lg shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                               <span class="text-xs text-neutral-400">Qty</span>
                                            </div>
                                            <input type="number"
                                                name="quantities[${variant.id}]"
                                                id="quantity_${variant.id}"
                                                value="1"
                                                min="1"
                                                ${!isOutOfStock ? `max="${variant.stock}"` : ''}
                                                ${isOutOfStock ? 'disabled' : ''}
                                                class="block w-full pl-10 rounded-lg border-neutral-300 focus:border-gold-500 focus:ring-gold-500 sm:text-sm disabled:bg-neutral-100 disabled:text-neutral-400">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    variantsHtml = `<div class="px-6 py-8 text-center bg-neutral-50 border-t border-neutral-100"><p class="text-sm text-neutral-400 italic">This product has no variants configured.</p></div>`;
                }

                productEl.innerHTML = `
                    <!-- Product Header -->
                    <div class="px-4 py-3 bg-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="relative group cursor-pointer h-14 w-14 rounded-lg bg-neutral-100 border border-neutral-200 overflow-hidden flex-shrink-0" onclick="openImageModal('${product.image_url}')">
                                <img src="${product.image_url}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110" onerror="this.src='/images/placeholder.jpg'">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white opacity-0 group-hover:opacity-100 transition drop-shadow" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-leather-900">${product.name}</h4>
                                <p class="text-xs text-neutral-400 mt-0.5">${product.variants ? product.variants.length : 0} variants available</p>
                            </div>
                        </div>
                        <button type="button" class="text-neutral-400 hover:text-red-600 transition p-2 rounded-lg hover:bg-red-50" onclick="removeProduct(${product.id})" title="Remove Product">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
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