@extends('layouts.email-base')

@section('title', 'Order Delivered - Leathers.pk')

@section('content')
    <h1 class="email-title">🎊 Your Order Has Been Delivered!</h1>
    
    <p class="email-text">
        Hi <strong>{{ $order->customer_name }}</strong>,
    </p>
    
    <p class="email-text">
        Wonderful news! Your order has been successfully delivered. We hope you're absolutely thrilled with your new premium leather goods from Leathers.pk!
    </p>
    
    <div class="info-box" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-left-color: #22c55e;">
        <div class="info-box-title" style="color: #166534;">✓ DELIVERED SUCCESSFULLY</div>
        <div class="info-box-value" style="color: #166534;">{{ $order->order_number }}</div>
    </div>
    
    <div style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); padding: 32px; border-radius: 12px; margin: 32px 0; text-align: center; color: white;">
        <div style="font-size: 24px; font-weight: 700; color: #d4af37; margin-bottom: 12px;">
            ⭐ Love Your Products?
        </div>
        <div style="font-size: 16px; color: #e5e7eb; margin-bottom: 24px; line-height: 1.6;">
            Share your experience and help other customers discover the quality they deserve. Your review means the world to us!
        </div>
    </div>
    
    <h3 class="email-title" style="font-size: 20px; text-align: center;">Rate Your Products</h3>
    <p class="email-text" style="text-align: center; color: #6b7280; margin-bottom: 32px;">
        Click the button below each product to leave a review
    </p>
    
    <div class="product-items">
        @foreach($order->items as $item)
        <div class="product-item">
            <img src="{{ asset($item->product->image ?? 'images/placeholder.png') }}" 
                 alt="{{ $item->product_name }}" 
                 class="product-image">
            <div class="product-details">
                <span class="product-name">{{ $item->product_name }}</span>
                <div class="product-meta">Quantity: {{ $item->quantity }}</div>
                <div class="product-meta">Price: <span class="product-price">Rs. {{ number_format($item->price) }}</span></div>
                
                <div style="margin-top: 16px;">
                    @if($item->product)
                    <a href="{{ route('products.show', $item->product->slug) }}#reviews" 
                       class="btn btn-gold" 
                       style="padding: 10px 24px; font-size: 14px; display: inline-block;">
                        ⭐ Write a Review
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div style="background-color: #fef3c7; border-left: 4px solid #d4af37; padding: 20px; margin: 32px 0; border-radius: 8px;">
        <div style="font-size: 14px; font-weight: 600; color: #92400e; margin-bottom: 8px;">
            🎁 EXCLUSIVE OFFER
        </div>
        <div style="font-size: 15px; color: #78350f; line-height: 1.6;">
            Leave a review and get <strong>10% OFF</strong> your next purchase! Check your email for your exclusive discount code after submitting your review.
        </div>
    </div>
    
    <div class="divider"></div>
    
    <h3 class="email-title" style="font-size: 20px;">Care Instructions</h3>
    <div style="background-color: #fafafa; padding: 20px; border-radius: 8px; margin: 20px 0;">
        <p class="email-text" style="margin-bottom: 12px;">
            <strong>💧 Keep your leather looking pristine:</strong>
        </p>
        <ul style="color: #6b7280; font-size: 15px; line-height: 1.8; margin-left: 20px;">
            <li>Clean with a soft, damp cloth regularly</li>
            <li>Apply leather conditioner every 3-6 months</li>
            <li>Avoid exposure to direct sunlight and heat</li>
            <li>Store in a cool, dry place when not in use</li>
        </ul>
    </div>
    
    <div class="divider"></div>
    
    <div style="text-align: center; margin: 40px 0;">
        <h3 class="email-title" style="font-size: 20px;">Any Issues?</h3>
        <p class="email-text">
            We're committed to your satisfaction. If there's anything wrong with your order, please contact us within 7 days.
        </p>
        <a href="mailto:hello@leathers.pk" class="btn btn-outline" style="margin-top: 16px; display: inline-block;">
            Contact Support
        </a>
    </div>
    
    <div style="background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); padding: 32px; border-radius: 12px; margin: 32px 0; text-align: center;">
        <div style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin-bottom: 12px;">
            Thank you for choosing Leathers.pk!
        </div>
        <div style="font-size: 15px; color: #6b7280; margin-bottom: 24px;">
            Your support means everything to us. We can't wait to serve you again!
        </div>
        <a href="{{ route('home') }}" class="btn btn-gold">Shop Again</a>
    </div>
@endsection
