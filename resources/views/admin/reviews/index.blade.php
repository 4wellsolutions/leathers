@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="h3 mb-0 text-gray-800">Reviews Management</h1>
            </div>
            <div class="col-md-6 text-end">
                <div class="btn-group" role="group">
                    <a href="{{ route('admin.reviews.index') }}"
                        class="btn btn-{{ !request('status') ? 'primary' : 'outline-primary' }}">All</a>
                    <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}"
                        class="btn btn-{{ request('status') === 'pending' ? 'primary' : 'outline-warning' }}">Pending</a>
                    <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}"
                        class="btn btn-{{ request('status') === 'approved' ? 'primary' : 'outline-success' }}">Approved</a>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Rating</th>
                                <th style="width: 40%;">Comment</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reviews as $review)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $review->product->image_url }}" alt="" class="rounded border me-2"
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                            <div class="small">
                                                <div class="fw-bold text-truncate" style="max-width: 150px;">
                                                    {{ $review->product->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($review->is_anonymous)
                                            <span class="badge bg-secondary">Anonymous</span>
                                        @else
                                            {{ $review->user ? $review->user->name : 'Guest' }}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= $review->rating ? '' : '-half-alt text-muted opacity-25' }}"
                                                    {{ $i > $review->rating && $i - 0.5 > $review->rating ? 'style="visibility:hidden"' : '' }}></i>
                                                {{-- Simpler approach for pure blade --}}
                                                @if($i <= $review->rating) ★ @else ☆ @endif
                                            @endfor
                                        </div>
                                    </td>
                                    <td>
                                        <p class="small mb-1 text-break">{{ Str::limit($review->comment, 150) }}</p>
                                        @if(!empty($review->images))
                                            <div class="d-flex gap-1 mt-1">
                                                @foreach($review->images as $img)
                                                    <a href="{{ asset('storage/' . $img) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $img) }}" class="rounded border"
                                                            style="width: 30px; height: 30px; object-fit: cover;">
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if($review->video)
                                            <a href="{{ asset('storage/' . $review->video) }}" target="_blank"
                                                class="badge bg-info text-decoration-none mt-1">
                                                <i class="fas fa-video"></i> Video
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $review->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if($review->is_approved)
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            @if(!$review->is_approved)
                                                <form action="{{ route('admin.reviews.update', $review) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="is_approved" value="1">
                                                    <button type="submit" class="btn btn-success" title="Approve">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.reviews.update', $review) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="is_approved" value="0">
                                                    <button type="submit" class="btn btn-warning" title="Unapprove">
                                                        <i class="fas fa-times"></i> Hide
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST"
                                                class="d-inline ms-1" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No reviews found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-4 py-3 border-top">
                    {{ $reviews->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection