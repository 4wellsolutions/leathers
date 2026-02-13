@extends('layouts.admin')

@section('title', 'Add Review')

@section('content')
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-leather-900">Add Review</h1>
                <p class="text-sm text-neutral-500">Manually add a review for a product</p>
            </div>
            <a href="{{ route('admin.reviews.index') }}"
                class="inline-flex items-center px-4 py-2 border border-neutral-300 rounded-lg text-sm font-medium text-neutral-700 bg-white hover:bg-neutral-50">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Reviews
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden max-w-3xl">
        <!-- Success/Error Messages -->
        <div id="form-message" class="hidden px-6 pt-4">
            <div id="form-message-content" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium"></div>
        </div>

        <form id="review-form" action="{{ route('admin.reviews.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <!-- Product Selection (Searchable with Image) -->
            <div class="relative" id="product-selector">
                <label class="block text-sm font-medium text-neutral-700">Product</label>
                <input type="hidden" name="product_id" id="product_id_input" value="{{ old('product_id') }}" required>

                <!-- Selected Product Display -->
                <div id="selected-product" class="mt-2 hidden">
                    <div class="flex items-start gap-4 p-3 border border-neutral-200 rounded-lg bg-neutral-50">
                        <div class="w-24 h-24 rounded-lg overflow-hidden border border-neutral-200 shadow-sm flex-shrink-0">
                            <img id="selected-product-img" src="" class="w-full h-full object-cover" alt="">
                        </div>
                        <div class="flex-1 min-w-0 pt-1">
                            <p id="selected-product-name" class="text-sm font-semibold text-neutral-900 truncate"></p>
                            <button type="button" onclick="document.getElementById('product-dropdown-wrap').classList.remove('hidden'); document.getElementById('product-search').focus(); document.getElementById('selected-product').classList.add('hidden');"
                                class="mt-2 inline-flex items-center text-xs text-gold-600 hover:text-gold-700 font-medium">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Change Product
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Search Input -->
                <div id="product-dropdown-wrap" class="mt-1">
                    <div class="relative">
                        <input type="text" id="product-search" autocomplete="off"
                            placeholder="Search for a product..."
                            class="block w-full pl-10 pr-3 py-2 text-sm border border-neutral-300 rounded-md focus:outline-none focus:ring-gold-500 focus:border-gold-500">
                        <svg class="absolute left-3 top-2.5 w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <!-- Dropdown List -->
                    <div id="product-dropdown" class="hidden absolute z-50 mt-1 w-full bg-white border border-neutral-200 rounded-md shadow-lg max-h-60 overflow-y-auto">
                    </div>
                </div>

                <p class="mt-1 text-sm text-red-600 hidden" id="error-product_id"></p>
            </div>

            <!-- User (Optional) -->
            <div>
                <label for="user_id" class="block text-sm font-medium text-neutral-700">User ID <span class="text-neutral-400 font-normal">(optional)</span></label>
                <input type="number" name="user_id" id="user_id" value="{{ old('user_id') }}" min="1"
                    class="mt-1 block w-full border-neutral-300 rounded-md shadow-sm focus:ring-gold-500 focus:border-gold-500 sm:text-sm"
                    placeholder="Enter user ID to link this review">
                <p class="mt-1 text-sm text-red-600 hidden" id="error-user_id"></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-700">Rating</label>
                <div class="mt-2 flex items-center space-x-4">
                    @for($i = 1; $i <= 5; $i++)
                        <label class="inline-flex items-center">
                            <input type="radio" name="rating" value="{{ $i }}" class="form-radio text-gold-600 focus:ring-gold-500 border-neutral-300" {{ old('rating', 5) == $i ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-neutral-700">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</span>
                        </label>
                    @endfor
                </div>
                <p class="mt-1 text-sm text-red-600 hidden" id="error-rating"></p>
            </div>

            <!-- Comment -->
            <div>
                <label for="comment" class="block text-sm font-medium text-neutral-700">Review Comment</label>
                <textarea id="comment" name="comment" rows="4"
                    class="mt-1 block w-full border-neutral-300 rounded-md shadow-sm focus:ring-gold-500 focus:border-gold-500 sm:text-sm"
                    placeholder="Write the review content here...">{{ old('comment') }}</textarea>
                <p class="mt-1 text-sm text-red-600 hidden" id="error-comment"></p>
            </div>

            <!-- Images -->
            <div>
                <label class="block text-sm font-medium text-neutral-700">Review Images</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-neutral-300 border-dashed rounded-md hover:border-gold-500 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-neutral-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-neutral-600">
                            <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-gold-600 hover:text-gold-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-gold-500">
                                <span>Upload files</span>
                                <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/*">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-neutral-500">PNG, JPG, GIF up to 2MB</p>
                    </div>
                </div>
                <!-- Image Previews -->
                <div id="image-previews" class="mt-3 flex flex-wrap gap-3"></div>
                <p class="mt-1 text-sm text-red-600 hidden" id="error-images"></p>
            </div>

            <!-- Options -->
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="is_approved" name="is_approved" type="checkbox" value="1" {{ old('is_approved', 1) ? 'checked' : '' }}
                            class="focus:ring-gold-500 h-4 w-4 text-gold-600 border-neutral-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="is_approved" class="font-medium text-neutral-700">Approve Immediately</label>
                        <p class="text-neutral-500">Review will be visible on the website immediately.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="is_anonymous" name="is_anonymous" type="checkbox" value="1" {{ old('is_anonymous') ? 'checked' : '' }}
                            class="focus:ring-gold-500 h-4 w-4 text-gold-600 border-neutral-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="is_anonymous" class="font-medium text-neutral-700">Mark as Anonymous</label>
                        <p class="text-neutral-500">Reviewer name will be hidden.</p>
                    </div>
                </div>

                <!-- Created Date -->
                <div>
                    <label for="created_at" class="block text-sm font-medium text-neutral-700">Created Date <span class="text-neutral-400 font-normal">(optional)</span></label>
                    <input type="datetime-local" name="created_at" id="created_at" value="{{ old('created_at', now()->format('Y-m-d\TH:i')) }}"
                        class="mt-1 block w-full border-neutral-300 rounded-md shadow-sm focus:ring-gold-500 focus:border-gold-500 sm:text-sm">
                </div>
            </div>

            <div class="pt-5 border-t border-neutral-200">
                <div class="flex justify-end">
                    <button type="submit" id="submit-btn" class="inline-flex justify-center items-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-leather-600 hover:bg-leather-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-all">
                        <svg id="submit-spinner" class="hidden animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="submit-text">Create Review</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // ===== Product Search =====
                const products = @json($products->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'image' => $p->image_url]));
                const searchInput = document.getElementById('product-search');
                const dropdown = document.getElementById('product-dropdown');
                const hiddenInput = document.getElementById('product_id_input');
                const selectedDisplay = document.getElementById('selected-product');
                const selectedImg = document.getElementById('selected-product-img');
                const selectedName = document.getElementById('selected-product-name');
                const dropdownWrap = document.getElementById('product-dropdown-wrap');

                function renderDropdown(filter = '') {
                    const filtered = products.filter(p => p.name.toLowerCase().includes(filter.toLowerCase()));
                    if (filtered.length === 0) {
                        dropdown.innerHTML = '<div class="px-3 py-4 text-sm text-neutral-400 text-center">No products found</div>';
                    } else {
                        dropdown.innerHTML = filtered.map(p => `
                            <div class="flex items-center px-3 py-2 cursor-pointer hover:bg-gold-50 transition ${hiddenInput.value == p.id ? 'bg-gold-50 border-l-2 border-gold-500' : ''}" data-id="${p.id}" data-name="${p.name}" data-image="${p.image}">
                                <img src="${p.image}" class="w-10 h-10 rounded object-cover mr-3 border border-neutral-200 flex-shrink-0" alt="" onerror="this.src='/images/placeholder.jpg'">
                                <span class="text-sm text-neutral-800 truncate">${p.name}</span>
                            </div>
                        `).join('');
                    }
                    dropdown.classList.remove('hidden');
                }

                function selectProduct(id, name, image) {
                    hiddenInput.value = id;
                    selectedImg.src = image;
                    selectedName.textContent = name;
                    selectedDisplay.classList.remove('hidden');
                    dropdownWrap.classList.add('hidden');
                    dropdown.classList.add('hidden');
                    searchInput.value = '';
                }

                searchInput.addEventListener('focus', () => renderDropdown(searchInput.value));
                searchInput.addEventListener('input', () => renderDropdown(searchInput.value));

                dropdown.addEventListener('click', function (e) {
                    const item = e.target.closest('[data-id]');
                    if (item) {
                        selectProduct(item.dataset.id, item.dataset.name, item.dataset.image);
                    }
                });

                document.addEventListener('click', function (e) {
                    if (!document.getElementById('product-selector').contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });

                // Pre-select if old value exists
                const oldValue = hiddenInput.value;
                if (oldValue) {
                    const found = products.find(p => p.id == oldValue);
                    if (found) selectProduct(found.id, found.name, found.image);
                }

                // ===== Image Previews =====
                const imageInput = document.getElementById('images');
                const previewContainer = document.getElementById('image-previews');
                const dt = new DataTransfer();

                if (imageInput && previewContainer) {
                    imageInput.addEventListener('change', function () {
                        // Add new files to DataTransfer
                        Array.from(this.files).forEach(file => {
                            dt.items.add(file);
                        });
                        this.files = dt.files;
                        renderPreviews();
                    });
                }

                function renderPreviews() {
                    previewContainer.innerHTML = '';
                    Array.from(dt.files).forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            const div = document.createElement('div');
                            div.className = 'relative group';
                            div.innerHTML = `
                                <div class="w-24 h-24 rounded-lg overflow-hidden border border-neutral-200 shadow-sm">
                                    <img src="${e.target.result}" class="w-full h-full object-cover" alt="Preview">
                                </div>
                                <button type="button" data-index="${index}"
                                    class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow opacity-0 group-hover:opacity-100 transition-opacity">
                                    &times;
                                </button>
                            `;
                            div.querySelector('button').addEventListener('click', function () {
                                removeFile(parseInt(this.dataset.index));
                            });
                            previewContainer.appendChild(div);
                        };
                        reader.readAsDataURL(file);
                    });
                }

                function removeFile(index) {
                    const newDt = new DataTransfer();
                    Array.from(dt.files).forEach((file, i) => {
                        if (i !== index) newDt.items.add(file);
                    });
                    dt.items.clear();
                    Array.from(newDt.files).forEach(f => dt.items.add(f));
                    imageInput.files = dt.files;
                    renderPreviews();
                }

                // ===== AJAX Form Submission =====
                const form = document.getElementById('review-form');
                const submitBtn = document.getElementById('submit-btn');
                const submitSpinner = document.getElementById('submit-spinner');
                const submitText = document.getElementById('submit-text');
                const formMessage = document.getElementById('form-message');
                const formMessageContent = document.getElementById('form-message-content');

                function clearErrors() {
                    document.querySelectorAll('[id^="error-"]').forEach(el => {
                        el.textContent = '';
                        el.classList.add('hidden');
                    });
                }

                function showErrors(errors) {
                    for (const [field, messages] of Object.entries(errors)) {
                        const key = field.replace('.', '_').replace(/\.\d+$/, '');
                        const el = document.getElementById('error-' + key);
                        if (el) {
                            el.textContent = messages[0];
                            el.classList.remove('hidden');
                        }
                    }
                }

                function showMessage(type, message) {
                    formMessage.classList.remove('hidden');
                    formMessageContent.className = 'flex items-center px-4 py-3 rounded-lg text-sm font-medium';
                    if (type === 'success') {
                        formMessageContent.classList.add('bg-green-50', 'text-green-800', 'border', 'border-green-200');
                        formMessageContent.innerHTML = `
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            ${message}`;
                    } else {
                        formMessageContent.classList.add('bg-red-50', 'text-red-800', 'border', 'border-red-200');
                        formMessageContent.innerHTML = `
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            ${message}`;
                    }
                    formMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }

                function setLoading(loading) {
                    submitBtn.disabled = loading;
                    submitSpinner.classList.toggle('hidden', !loading);
                    submitText.textContent = loading ? 'Submitting...' : 'Create Review';
                    submitBtn.classList.toggle('opacity-75', loading);
                    submitBtn.classList.toggle('cursor-not-allowed', loading);
                }

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    clearErrors();
                    formMessage.classList.add('hidden');
                    setLoading(true);

                    const formData = new FormData(form);

                    // Re-attach files from DataTransfer since FormData might not pick them up correctly
                    formData.delete('images[]');
                    Array.from(dt.files).forEach(file => {
                        formData.append('images[]', file);
                    });

                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    })
                    .then(async response => {
                        const data = await response.json();
                        if (!response.ok) {
                            if (response.status === 422 && data.errors) {
                                showErrors(data.errors);
                                showMessage('error', data.message || 'Please fix the errors below.');
                            } else {
                                showMessage('error', data.message || 'Something went wrong. Please try again.');
                            }
                            setLoading(false);
                            return;
                        }

                        showMessage('success', data.message || 'Review created successfully! Redirecting...');
                        setLoading(false);
                        submitBtn.disabled = true;

                        setTimeout(() => {
                            window.location.href = data.redirect_url || '{{ route("admin.reviews.index") }}';
                        }, 1000);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showMessage('error', 'A network error occurred. Please try again.');
                        setLoading(false);
                    });
                });
            });
        </script>
    @endpush
@endsection
