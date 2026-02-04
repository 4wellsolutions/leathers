@extends('layouts.app')

@section('meta_title', 'Edit/Re-submit My Review - ' . $product->name)

@section('content')
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-md mx-auto bg-white shadow-sm overflow-hidden">
            {{-- Header --}}
            <div class="px-4 py-3 border-b border-gray-100 flex items-center bg-white sticky top-0 z-10">
                <a href="{{ isset($order) ? route('my-orders.show', $order->order_number) : url()->previous() }}"
                    class="text-gray-400 mr-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-base font-bold text-gray-800">
                    {{ isset($existingReview) ? 'Your Review' : 'Write a Review' }}
                </h1>
            </div>

            <div class="overflow-y-auto" style="height: calc(100vh - 60px);">
                {{-- Product Card --}}
                <div class="p-3 flex items-start border-b border-gray-100 bg-white">
                    <div class="w-14 h-14 border border-gray-200 rounded-md overflow-hidden flex-shrink-0 mr-3">
                        <img src="{{ isset($orderItem) ? $orderItem->image_url : $product->image_url }}"
                            alt="{{ $product->name }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h2 class="text-xs font-semibold text-gray-900 line-clamp-2 leading-tight mb-1">{{ $product->name }}
                        </h2>
                        <div class="text-[10px] text-gray-500">Color:
                            @if(isset($orderItem) && $orderItem->variant && $orderItem->variant->color)
                                {{ $orderItem->variant->color->name }}
                            @else
                                {{ $product->variants->first()->color->name ?? 'Default' }}
                            @endif
                        </div>
                    </div>
                </div>

                @if(isset($existingReview))
                    {{-- Existing Review View --}}
                    <div class="p-6 text-center space-y-6">
                        <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Review Submitted!</h3>
                            <p class="text-gray-500 text-sm mt-2">You have already submitted a review for this product.</p>
                        </div>

                        {{-- Review Details Preview --}}
                        <div class="bg-gray-50 rounded-xl p-4 text-left border border-gray-100">
                            <div class="flex items-center mb-2">
                                <div class="flex text-gold-500 text-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span>{{ $i <= $existingReview->rating ? '★' : '☆' }}</span>
                                    @endfor
                                </div>
                                <span
                                    class="text-xs text-gray-400 ml-2">{{ $existingReview->created_at->format('M d, Y') }}</span>
                            </div>
                            <p class="text-gray-700 text-sm italic">"{{ $existingReview->comment }}"</p>
                        </div>

                        <div class="pt-4">
                            @if(isset($order))
                                <a href="{{ route('my-orders.show', $order->order_number) }}"
                                    class="block w-full bg-gray-900 text-white font-bold py-3.5 rounded-xl shadow-lg hover:bg-gray-800 transition">
                                    Back to Order Details
                                </a>
                            @else
                                <a href="{{ route('products.show', $product->slug) }}"
                                    class="block w-full bg-gray-900 text-white font-bold py-3.5 rounded-xl shadow-lg hover:bg-gray-800 transition">
                                    Back to Product
                                </a>
                            @endif
                        </div>
                    </div>
                @else
                    {{-- Review Form --}}
                    <form action="{{ route('reviews.store', $product) }}" method="POST" enctype="multipart/form-data"
                        class="space-y-4 p-4" id="review-form">
                        @csrf

                        {{-- Rating --}}
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-bold text-gray-900">Overall Rating</label>
                            <div class="flex flex-row-reverse space-x-reverse space-x-1 group">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating" id="rating-{{ $i }}" value="{{ $i }}" class="peer sr-only"
                                        required>
                                    <label for="rating-{{ $i }}"
                                        class="cursor-pointer text-gray-200 peer-checked:text-gold-500 hover:text-gold-500 peer-hover:text-gold-500 text-2xl">★</label>
                                @endfor
                            </div>
                        </div>

                        {{-- Comment --}}
                        <div>
                            <textarea name="comment" rows="4"
                                class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3 text-sm placeholder-gray-400 focus:ring-1 focus:ring-gold-500 focus:border-gold-500 resize-none"
                                placeholder="What do you think of the quality and appearance?"></textarea>
                        </div>

                        {{-- Media Upload --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2">Add Photos/Video</label>
                            <div class="flex flex-wrap gap-2">
                                {{-- Previews Container --}}
                                <div id="thumbnails" class="flex flex-wrap gap-2"></div>

                                {{-- Upload Button --}}
                                <label
                                    class="w-20 h-20 bg-gray-50 flex flex-col items-center justify-center border border-dashed border-gray-300 rounded-lg cursor-pointer text-gray-400 hover:bg-gray-100 transition flex-shrink-0">
                                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-[10px] text-center leading-tight">Upload</span>
                                    <input type="file" id="media-input" multiple accept="image/*,video/*" class="hidden">
                                </label>
                            </div>
                        </div>

                        {{-- Anonymous Checkbox --}}
                        <div class="flex items-center">
                            <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1"
                                class="w-4 h-4 border-gray-300 rounded text-gold-600 focus:ring-gold-500">
                            <label for="is_anonymous" class="ml-2 text-sm text-gray-700">Review Anonymously</label>
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-2 pb-6">
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-pink-600 to-pink-700 text-white font-bold py-3.5 rounded-xl shadow-lg hover:from-pink-700 hover:to-pink-800 transition transform active:scale-95">
                                Submit Review
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const mediaInput = document.getElementById('media-input');
                const thumbnailsContainer = document.getElementById('thumbnails');
                let selectedFiles = []; // Global array to store files

                if (mediaInput && thumbnailsContainer) {
                    mediaInput.addEventListener('change', function (e) {
                        if (this.files && this.files.length > 0) {
                            Array.from(this.files).forEach(file => {
                                // Add to array
                                selectedFiles.push(file);

                                // Create preview
                                renderPreview(file, selectedFiles.length - 1);
                            });
                        }
                        // Reset input so same file can be selected again if needed
                        this.value = '';
                    });
                }

                function renderPreview(file, index) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        const div = document.createElement('div');
                        div.className = 'w-20 h-20 rounded-lg overflow-hidden border border-gray-200 relative flex-shrink-0 bg-white shadow-sm group';
                        div.dataset.index = index; // Store raw index, but retrieval relies on array

                        // Delete Button
                        const deleteBtn = document.createElement('button');
                        deleteBtn.type = 'button';
                        deleteBtn.className = 'absolute top-0.5 right-0.5 bg-black/50 hover:bg-red-500 text-white rounded-full p-0.5 opacity-0 group-hover:opacity-100 transition-opacity z-10';
                        deleteBtn.innerHTML = `<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>`;
                        deleteBtn.onclick = function () {
                            removeFile(file);
                            div.remove();
                        };

                        let content = '';
                        if (file.type.startsWith('video/')) {
                            content = `
                                        <div class="w-full h-full bg-gray-50 flex items-center justify-center text-gray-400">
                                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    `;
                        } else {
                            content = `<img src="${event.target.result}" class="w-full h-full object-cover">`;
                        }

                        div.innerHTML = content;
                        div.appendChild(deleteBtn);
                        thumbnailsContainer.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                }

                function removeFile(fileToRemove) {
                    selectedFiles = selectedFiles.filter(f => f !== fileToRemove);
                }

                // Error Helper
                function showError(message) {
                    const form = document.getElementById('review-form');
                    // Remove existing
                    const existing = form.querySelector('.global-error');
                    if (existing) existing.remove();

                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'global-error bg-red-50 border-l-4 border-red-500 p-4 mb-4 rounded-md';
                    errorAlert.innerHTML = `
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-red-700 font-medium">${message}</p>
                                    </div>
                                </div>
                            `;
                    form.insertBefore(errorAlert, form.firstChild);
                    errorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }

                const form = document.getElementById('review-form');
                if (form) {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();

                        const submitBtn = form.querySelector('button[type="submit"]');
                        const originalBtnHtml = submitBtn.innerHTML;
                        const formData = new FormData(form);

                        // Append collected files
                        selectedFiles.forEach(file => {
                            formData.append('media[]', file);
                        });

                        // Clear previous errors
                        form.querySelectorAll('.error-message').forEach(el => el.remove());
                        form.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
                        const existingGlobal = form.querySelector('.global-error');
                        if (existingGlobal) existingGlobal.remove();

                        // Disable button
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="inline-block animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></span> Submitting...';

                        fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                            .then(async response => {
                                const data = await response.json().catch(() => ({}));

                                if (response.ok) {
                                    // Success modal
                                    const successHtml = `
                                            <div class="fixed inset-0 flex items-center justify-center z-[100] bg-black/60 backdrop-blur-sm p-4">
                                                <div class="bg-white rounded-2xl p-8 max-w-sm w-full text-center shadow-2xl transform transition-all scale-100">
                                                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </div>
                                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Review Submitted!</h3>
                                                    <p class="text-gray-600 mb-6">${data.message || 'Thank you for your feedback!'}</p>
                                                    <button onclick="window.location.href='${data.redirect_url}'" class="w-full py-4 bg-gradient-to-r from-pink-600 to-pink-700 text-white rounded-xl font-bold hover:from-pink-700 hover:to-pink-800 transition shadow-lg">
                                                        Continue
                                                    </button>
                                                </div>
                                            </div>
                                        `;
                                    document.body.insertAdjacentHTML('beforeend', successHtml);
                                } else if (response.status === 422) {
                                    // Validation Failed
                                    submitBtn.disabled = false;
                                    submitBtn.innerHTML = originalBtnHtml;

                                    if (data.errors) {
                                        Object.keys(data.errors).forEach(key => {
                                            // Handle array keys like media.0 => media
                                            const fieldName = key.split('.')[0];
                                            const input = form.querySelector(`[name="${fieldName}"]`) ||
                                                form.querySelector(`[name="${fieldName}[]"]`);

                                            if (input) {
                                                input.classList.add('border-red-500');
                                                const errorDiv = document.createElement('p');
                                                errorDiv.className = 'text-red-500 text-xs mt-1 error-message font-medium';
                                                errorDiv.innerText = data.errors[key][0];

                                                // Handle Radio inputs layout
                                                if (input.type === 'radio') {
                                                    input.closest('div').parentElement.appendChild(errorDiv);
                                                } else {
                                                    input.parentElement.appendChild(errorDiv);
                                                }
                                            } else if (fieldName === 'media') {
                                                showError(data.errors[key][0]);
                                            }
                                        });
                                    }

                                    showError('Please correct the errors below.');
                                } else {
                                    throw new Error(data.message || 'Something went wrong. Please try again.');
                                }
                            })
                            .catch(error => {
                                console.error('Submission error:', error);
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalBtnHtml;
                                showError(error.message || 'Connection lost. Please try again.');
                            });
                    });
                }
            });
        </script>
    @endpush
@endsection