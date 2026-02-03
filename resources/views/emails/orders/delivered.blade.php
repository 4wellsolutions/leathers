@extends('layouts.email-base')

@section('title', 'Order Delivered - ' . $order->order_number)

@section('content')
    <h1 class="email-title">✨ It's Home!</h1>

    <p class="email-text">
        Hello <strong>{{ $order->customer_name }}</strong>,
    </p>

    <p class="email-text">
        We're delighted to confirm that your premium leather selection has been successfully delivered. We hope it exceeds
        every expectation of quality and craftsmanship.
    </p>

    <div class="info-box">
        <div class="info-box-title">Status</div>
        <div class="info-box-value" style="color: #166534;">Delivered Successfully</div>
        <div class="info-box-value" style="color: #666; font-size: 13px; margin-top: 5px;">Order #{{ $order->order_number }}
        </div>
    </div>

    <div class="divider"></div>

    <h3 class="email-title" style="font-size: 20px;">Share Your Thoughts</h3>
    <p class="email-text">
        Our artisans pour their soul into every stitch. Your feedback is the bridge between our workshop and your
        satisfaction.
    </p>

    <div class="product-items">
        @foreach($order->items as $item)
            <div class="product-item">
                <img src="{{ $item->image_url }}" alt="{{ $item->product_name }}" class="product-image">
                <div class="product-details">
                    <span class="product-name">{{ $item->product_name }}</span>
                    @if($item->product)
                        <div style="margin-top: 10px;">
                            <a href="{{ route('products.show', $item->product->slug) }}#reviews" class="btn btn-gold"
                                style="padding: 6px 12px; font-size: 12px;">Write a Review</a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="divider"></div>

    <h3 class="email-title" style="font-size: 20px;">Leather Longevity</h3>
    <div
        style="background-color: #F8F5F2; padding: 20px; border-radius: 8px; border-left: 4px solid #C5A359; margin-bottom: 20px;">
        <div class="info-box-title" style="margin-bottom: 10px;">Care Guidelines</div>
        <ul style="margin: 0; padding-left: 20px; color: #5C4A42; font-size: 14px; line-height: 1.6;">
            <li>Gently wipe with a soft, dry cloth after use.</li>
            <li>Condition every 4 months to maintain suppleness.</li>
            <li>Avoid prolonged exposure to moisture or high heat.</li>
            <li>Store in the provided dust bag when not in use.</li>
        </ul>
    </div>

    <div class="divider"></div>

    <div style="text-align: center; margin-bottom: 40px;">
        <h3 class="email-title" style="font-size: 16px; margin-bottom: 10px;">Need Assistance?</h3>
        <p class="email-text" style="font-size: 14px;">If your order is anything less than perfect, our concierge team is
            here to help.</p>
        <a href="mailto:hello@leathers.pk"
            style="color: #C5A359; font-weight: 600; text-decoration: none; font-size: 14px; border-bottom: 1px dashed #C5A359;">Contact
            Our Concierge</a>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ route('home') }}" class="btn btn-gold">DISCOVER NEW ARRIVALS</a>
    </div>
@endsection