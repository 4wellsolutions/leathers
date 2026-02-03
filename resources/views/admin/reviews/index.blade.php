@extends('layouts.admin')

@section('title', 'Reviews')

@section('content')
    <!-- Sticky Header -->
    <div
        class="sticky top-0 z-10 bg-neutral-100/95 backdrop-blur-sm border-b border-neutral-200 -mx-4 sm:-mx-6 md:-mx-8 px-4 sm:px-6 md:px-8 py-4 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-leather-900">Reviews Management</h1>
                <p class="text-sm text-neutral-500">Manage customer reviews and ratings</p>
            </div>
            
            <div class="flex space-x-2">
                <a href="{{ route('admin.reviews.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium {{ !request('status') ? 'bg-leather-900 text-white shadow-sm' : 'bg-white text-neutral-700 border-neutral-300 hover:bg-neutral-50' }}">
                    All
                </a>
                <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium {{ request('status') === 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white text-neutral-700 border-neutral-300 hover:bg-neutral-50' }}">
                    Pending
                </a>
                <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium {{ request('status') === 'approved' ? 'bg-green-600 text-white shadow-sm' : 'bg-white text-neutral-700 border-neutral-300 hover:bg-neutral-50' }}">
                    Approved
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-8">
        <div class="bg-white overflow-hidden rounded-xl border border-neutral-200 shadow-sm">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-leather-100 text-leather-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">Total Reviews</dt>
                            <dd class="text-2xl font-semibold text-leather-900">{{ $reviews->total() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden rounded-xl border border-neutral-200 shadow-sm">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-amber-100 text-amber-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">Pending Approval</dt>
                            <dd class="text-2xl font-semibold text-amber-600">{{ \App\Models\Review::where('is_approved', false)->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden rounded-xl border border-neutral-200 shadow-sm">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-green-100 text-green-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">Average Rating</dt>
                            <dd class="text-2xl font-semibold text-green-600">{{ number_format(\App\Models\Review::avg('rating'), 1) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Table -->
    <div x-data="{ editingReview: null }" class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200">
                <thead class="bg-neutral-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Product</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Rating</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider w-1/3">Comment</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-neutral-200">
                    @forelse($reviews as $review)
                        <tr class="hover:bg-neutral-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.products.edit', $review->product) }}" target="_blank" class="flex items-center group">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-lg object-cover border border-neutral-200 group-hover:border-gold-500 transition-colors" src="{{ $review->product->image_url }}" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-leather-900 truncate max-w-[150px] group-hover:text-gold-600 transition-colors">{{ $review->product->name }}</div>
                                        <div class="text-xs text-neutral-500">{{ $review->product->category->name ?? 'Category' }}</div>
                                    </div>
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($review->is_anonymous)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-neutral-100 text-neutral-800">
                                        Anonymous
                                    </span>
                                @else
                                    <div class="text-sm font-medium text-leather-900">{{ $review->user ? $review->user->name : 'Guest' }}</div>
                                    @if($review->user)
                                        <div class="text-xs text-neutral-500">{{ $review->user->email }}</div>
                                    @endif
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex text-gold-500">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-neutral-300' }}" viewBox="0 0 24 24">
                                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" fill="currentColor" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-xs font-bold text-neutral-600">{{ $review->rating }}.0</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-neutral-600 line-clamp-2 mb-2">{{ $review->comment }}</div>
                                
                                @if($review->images || $review->video)
                                    <div class="flex space-x-2">
                                        @if(!empty($review->images))
                                            @foreach($review->images as $img)
                                                <a href="{{ asset('storage/' . $img) }}" target="_blank" class="block h-8 w-8 rounded overflow-hidden border border-neutral-200 hover:border-gold-500 transition-colors">
                                                    <img src="{{ asset('storage/' . $img) }}" class="h-full w-full object-cover">
                                                </a>
                                            @endforeach
                                        @endif
                                        @if($review->video)
                                            <a href="{{ asset('storage/' . $review->video) }}" target="_blank" class="flex items-center justify-center h-8 w-8 rounded border border-neutral-200 bg-neutral-50 text-neutral-500 hover:text-gold-600 hover:border-gold-500 transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-neutral-900">{{ $review->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-neutral-500">{{ $review->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($review->is_approved)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <button 
                                        type="button" 
                                        @click="editingReview = { id: {{ $review->id }}, comment: '{{ addslashes($review->comment) }}', is_approved: {{ $review->is_approved ? 'true' : 'false' }} }"
                                        class="inline-flex items-center px-3 py-1.5 border border-neutral-300 text-xs font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </button>

                                    @if(!$review->is_approved)
                                        <form action="{{ route('admin.reviews.update', $review) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="is_approved" value="1">
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Approve
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.reviews.update', $review) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="is_approved" value="0">
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-amber-300 text-xs font-medium rounded-md text-amber-700 bg-amber-50 hover:bg-amber-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                                Hide
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this review permanently?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-red-300 text-xs font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-neutral-900">No reviews found</h3>
                                <p class="mt-1 text-sm text-neutral-500">There are no reviews matching your criteria.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="bg-white px-4 py-3 border-t border-neutral-200 sm:px-6">
            {{ $reviews->withQueryString()->links() }}
        </div>

        <!-- Edit Modal -->
        <div x-show="editingReview" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="editingReview" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="editingReview" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-leather-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-leather-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Edit Review
                            </h3>
                            <div class="mt-2">
                                <form :action="`/admin/reviews/${editingReview?.id}`" method="POST" id="editReviewForm">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-4">
                                        <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                                        <div class="mt-1">
                                            <textarea id="comment" name="comment" rows="4" class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border-gray-300 rounded-md" x-model="editingReview.comment"></textarea>
                                        </div>
                                    </div>

                                    <div class="flex items-center">
                                        <input id="is_approved" name="is_approved" type="checkbox" value="1" x-model="editingReview.is_approved" class="h-4 w-4 text-gold-600 focus:ring-gold-500 border-gray-300 rounded">
                                        <label for="is_approved" class="ml-2 block text-sm text-gray-900">
                                            Approve this review
                                        </label>
                                    </div>
                                    
                                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-leather-900 text-base font-medium text-white hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-leather-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Save Changes
                                        </button>
                                        <button type="button" @click="editingReview = null" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection