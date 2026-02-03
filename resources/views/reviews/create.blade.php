@extends('layouts.app')

@section('meta_title', 'Edit/Re-submit My Review - ' . $product->name)

@section('content')
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-md mx-auto bg-white shadow-sm overflow-hidden">
            {{-- Header --}}
            <div class="px-4 py-3 border-b border-gray-100 flex items-center">
                <a href="{{ url()->previous() }}" class="text-gray-400 mr-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-lg font-bold text-gray-800">Edit/Re-submit My Review</h1>
            </div>

            {{-- Product Card --}}
            <div class="p-4 flex items-start border-b border-gray-100 bg-white">
                <div class="w-16 h-16 border border-gray-200 rounded-md overflow-hidden flex-shrink-0 mr-3">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-gray-900 line-clamp-2 leading-tight mb-1">{{ $product->name }}
                    </h2>
                    <div class="text-xs text-gray-500">Color family:
                        {{ $product->variants->first()->color->name ?? 'Default' }}
                    </div>
                </div>
            </div>

            <form action="{{ route('reviews.store', $product) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6" id="review-form">
                @csrf

                {{-- Rating --}}
                <div class="mb-6 flex items-center justify-between">
                    <label class="text-sm font-bold text-gray-900">Overall Rating</label>
                    <div class="flex flex-row-reverse space-x-reverse space-x-1 group">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" name="rating" id="rating-{{ $i }}" value="{{ $i }}" class="peer sr-only"
                                required>
                            <label for="rating-{{ $i }}"
                                class="cursor-pointer text-gray-200 peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 text-2xl">★</label>
                        @endfor
                    </div>
                </div>



                {{-- Comment --}}
                <div class="mb-4">
                    <textarea name="comment" rows="5"
                        class="w-full bg-gray-50 border-none rounded-sm p-3 text-sm placeholder-gray-400 focus:ring-0 resize-none"
                        placeholder="What do you think of the quality and appearance?"></textarea>
                </div>

                {{-- Media Upload --}}
                <div class="mb-4">
                    <label
                        class="w-20 h-20 bg-gray-50 flex flex-col items-center justify-center border border-dashed border-gray-300 rounded-sm cursor-pointer text-gray-400 hover:bg-gray-100 transition">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-[10px] text-center leading-tight">Upload<br>Photo/Video</span>
                        <input type="file" name="media[]" multiple accept="image/*,video/*" class="hidden">
                    </label>
                </div>

                {{-- Anonymous Checkbox --}}
                <div class="mb-8 flex items-center">
                    <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1"
                        class="w-5 h-5 border-gray-300 rounded text-pink-600 focus:ring-pink-500">
                    <label for="is_anonymous" class="ml-2 text-sm text-gray-700">Anonymously</label>
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                    class="w-full bg-pink-600 text-white font-bold py-3 rounded-sm shadow-md hover:bg-pink-700 transition">
                    Submit
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('review-form').addEventListener('submit', function (e) {
                e.preventDefault();

                const form = this;
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;
                const formData = new FormData(form);

                // Clear previous errors
                document.querySelectorAll('.error-message').forEach(el => el.remove());
                form.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));

                // Disable button
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="inline-block animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></span> Submitting...';

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            const successHtml = `
                                        <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                                            <div class="bg-white rounded-xl p-8 max-w-sm w-full text-center shadow-2xl transform transition-all scale-100">
                                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                                <h3 class="text-xl font-bold text-gray-900 mb-2">Review Submitted!</h3>
                                                <p class="text-gray-600 mb-6">${data.message}</p>
                                                <button onclick="window.location.href='${data.redirect_url}'" class="w-full py-3 bg-gold-600 text-white rounded-lg font-bold hover:bg-gold-700 transition">
                                                    Continue
                                                </button>
                                            </div>
                                        </div>
                                    `;
                            document.body.insertAdjacentHTML('beforeend', successHtml);
                        } else {
                            // Handle validation errors if returned in specific format (Laravel default is 422)
                            throw new Error(data.message || 'Something went wrong');
                        }
                    })
                    .catch(error => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;

                        if (error.response && error.response.status === 422) {
                            // This part depends on how fetch handles non-200. Fetch doesn't throw on 4xx.
                            // We need to check response.ok in the first .then block actually.
                        } else {
                            // console.error(error); // Keep silent or generic alert
                        }
                    });
            });

            // Better Fetch Handling for 422
            const originalFetch = window.fetch;
            window.fetch = function () {
                return originalFetch.apply(this, arguments).then(async response => {
                    if (response.status === 422) {
                        const data = await response.json();
                        const form = document.getElementById('review-form');
                        const submitBtn = form.querySelector('button[type="submit"]');

                        submitBtn.disabled = false;
                        submitBtn.innerHTML = submitBtn.getAttribute('data-original-text') || 'Submit Review'; // Fallback

                        Object.keys(data.errors).forEach(key => {
                            // Handle array inputs like media.0
                            const fieldName = key.split('.')[0];
                            const input = form.querySelector(`[name="${fieldName}"]`) || form.querySelector(`[name="${fieldName}[]"]`);

                            if (input) {
                                input.classList.add('border-red-500');
                                const errorDiv = document.createElement('p');
                                errorDiv.className = 'text-red-500 text-xs mt-1 error-message';
                                errorDiv.innerText = data.errors[key][0];
                                input.closest('div').appendChild(errorDiv);
                            }
                        });

                        throw new Error('Validation Failed'); // Stop promise chain
                    }
                    return response;
                });
            };
        </script>
    @endpush
@endsection