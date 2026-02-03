@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Reviews Management</h1>
            <div class="btn-group shadow-sm mt-3 mt-sm-0" role="group">
                <a href="{{ route('admin.reviews.index') }}"
                    class="btn btn-sm btn-{{ !request('status') ? 'primary' : 'light text-primary border' }}">All</a>
                <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}"
                    class="btn btn-sm btn-{{ request('status') === 'pending' ? 'warning' : 'light text-warning border' }}">Pending</a>
                <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}"
                    class="btn btn-sm btn-{{ request('status') === 'approved' ? 'success' : 'light text-success border' }}">Approved</a>
            </div>
        </div>

        <div class="card shadow mb-4 border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0 align-middle">
                        <thead class="bg-light text-dark">
                            <tr>
                                <th class="border-0 px-4 py-3" style="min-width: 250px;">Product</th>
                                <th class="border-0 px-4 py-3" style="min-width: 150px;">Customer</th>
                                <th class="border-0 px-4 py-3" style="min-width: 120px;">Rating</th>
                                <th class="border-0 px-4 py-3" style="min-width: 300px;">Comment</th>
                                <th class="border-0 px-4 py-3 text-nowrap">Date</th>
                                <th class="border-0 px-4 py-3">Status</th>
                                <th class="border-0 px-4 py-3 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reviews as $review)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="{{ $review->product->image_url }}" alt="" class="rounded border"
                                                    style="width: 48px; height: 48px; object-fit: cover;">
                                            </div>
                                            <div class="ms-3">
                                                <div class="fw-bold text-dark text-truncate" style="max-width: 200px;">
                                                    {{ $review->product->name }}</div>
                                                <small class="text-muted d-block">{{ $review->product->category->name ?? 'Category' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($review->is_anonymous)
                                            <span class="badge bg-secondary rounded-pill fw-normal">Anonymous</span>
                                        @else
                                            <div class="fw-bold text-dark">{{ $review->user ? $review->user->name : 'Guest' }}</div>
                                            @if($review->user)
                                                <small class="text-muted">{{ $review->user->email }}</small>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-warning small text-nowrap">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= $review->rating ? '' : '-half-alt text-muted opacity-25' }}"
                                                    {{ $i > $review->rating && $i - 0.5 > $review->rating ? 'style="visibility:hidden"' : '' }}></i>
                                            @endfor
                                        </div>
                                        <small class="text-muted fw-bold">{{ $review->rating }}.0 / 5.0</small>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div style="max-height: 100px; overflow-y: auto;">
                                            <p class="small mb-2 text-secondary">{{ $review->comment }}</p>
                                        </div>
                                        
                                        @if($review->images || $review->video)
                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                @if(!empty($review->images))
                                                    @foreach($review->images as $img)
                                                        <a href="{{ asset('storage/' . $img) }}" target="_blank" class="d-block border rounded overflow-hidden shadow-sm" style="width: 40px; height: 40px;">
                                                            <img src="{{ asset('storage/' . $img) }}" class="w-100 h-100" style="object-fit: cover;">
                                                        </a>
                                                    @endforeach
                                                @endif
                                                @if($review->video)
                                                    <a href="{{ asset('storage/' . $review->video) }}" target="_blank"
                                                        class="btn btn-sm btn-light border d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-video text-primary"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-nowrap text-secondary">
                                        {{ $review->created_at->format('M d, Y') }}<br>
                                        <small>{{ $review->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($review->is_approved)
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-2 rounded-pill fw-normal">Approved</span>
                                        @else
                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning px-3 py-2 rounded-pill fw-normal">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <div class="btn-group btn-group-sm shadow-sm">
                                            @if(!$review->is_approved)
                                                <form action="{{ route('admin.reviews.update', $review) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="is_approved" value="1">
                                                    <button type="submit" class="btn btn-success" title="Approve" style="border-radius: 0.25rem 0 0 0.25rem;">
                                                        <i class="fas fa-check me-1"></i> Approve
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.reviews.update', $review) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="is_approved" value="0">
                                                    <button type="submit" class="btn btn-warning" title="Unapprove" style="border-radius: 0.25rem 0 0 0.25rem;">
                                                        <i class="fas fa-eye-slash me-1"></i> Hide
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Delete" style="border-radius: 0 0.25rem 0.25rem 0;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted mb-2"><i class="fas fa-inbox fa-3x opacity-25"></i></div>
                                        <p class="text-muted fw-bold mb-0">No reviews found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-4 py-3 border-top bg-light">
                    {{ $reviews->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection