<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f3f4f6;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .product-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 15px;
        }

        .rating {
            color: #f59e0b;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .comment {
            font-style: italic;
            color: #4b5563;
            background: #f3f4f6;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #000;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;
        }

        .info-row {
            margin-bottom: 5px;
            font-size: 14px;
        }

        .label {
            font-weight: 600;
            color: #374151;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>New Review Submitted</h2>
            <p>A new review is pending your approval.</p>
        </div>

        <div class="product-info">
            <img src="{{ $review->product->image_url }}" alt="{{ $review->product->name }}" class="product-img">
            <div>
                <div style="font-weight: bold;">{{ $review->product->name }}</div>
                <div style="font-size: 12px; color: #6b7280;">{{ $review->product->category->name ?? 'Category' }}</div>
            </div>
        </div>

        <div class="info-row">
            <span class="label">Customer:</span>
            {{ $review->user ? $review->user->name : 'Guest' }}
            @if($review->user) ({{ $review->user->email }}) @endif
        </div>

        @if($review->is_anonymous)
            <div class="info-row">
                <span class="label">Status:</span> Posted Anonymously
            </div>
        @endif

        <div class="rating">
            @for($i = 1; $i <= 5; $i++)
                {{ $i <= $review->rating ? '★' : '☆' }}
            @endfor
            <span style="color: #6b7280; font-size: 14px; margin-left: 5px;">({{ $review->rating }}/5)</span>
        </div>

        <div class="comment">
            "{{ $review->comment ?? 'No comment provided.' }}"
        </div>

        @if(!empty($review->images))
            <div style="margin-bottom: 20px;">
                <div class="label" style="margin-bottom: 10px;">Attached Images:</div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    @foreach($review->images as $img)
                        <a href="{{ asset($img) }}" target="_blank">
                            <!-- Use public path if possible, or simple asset() link -->
                            <img src="{{ asset($img) }}"
                                style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 1px solid #e5e7eb;">
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <div style="text-align: center;">
            <a href="{{ route('admin.reviews.edit', $review) }}" class="btn">View & Approve Review</a>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>

</html>