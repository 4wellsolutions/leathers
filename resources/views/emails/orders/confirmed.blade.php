@extends('layouts.email-base')

@section('title', 'Order Confirmed - Leathers.pk')

@section('content')
    <h1 class="email-title">✅ Your Order is Confirmed!</h1>
    
    <p class="email-text">
        Hi <strong>{{ $order->customer_name }}</strong>,
    </p>
    
    <p class="email-text">
        Great news! We've confirmed your order and our artisans are now carefully preparing your premium leather goods. Your order will be shipped within 2-3 business days.
    </p>
    
    <div class="info-box" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-left-color: #22c55e;">
        <div class="info-box-title" style="color: #166534;">✓ Order Confirmed</div>
        <div class="info-box-value" style="color: #166534;">{{ $order->order_number }}</div>
    </div>
    
    <div style="background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 20px; margin: 24px 0; border-radius: 8px;">
        <div style="font-size: 14px; font-weight: 600; color: #92400e; margin-bottom: 8px;">
            📦 ESTIMATED DELIVERY
        </div>
        <div style="font-size: 18px; font-weight: 700; color: #92400e;">
            {{ now()->addDays(5)->format('F d') }} - {{ now()->addDays(7)->format('F d, Y') }}
        </div>
    </div>
    
    <div class="divider"></div>
    
    <h3 class="email-title" style="font-size: 20px;">Your Items</h3>
    
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
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="order-summary">
        <div class="summary-row">
            <span class="summary-label">Subtotal:</span>
            <span class="summary-value">Rs. {{ number_format($order->subtotal) }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Shipping:</span>
            <span class="summary-value">Rs. {{ number_format($order->shipping_cost) }}</span>
        </div>
        <div class="summary-row total">
            <span>Total Paid:</span>
            <span>Rs. {{ number_format($order->total) }}</span>
        </div>
    </div>
    
    <div class="divider"></div>
    
    <h3 class="email-title" style="font-size: 20px;">Delivery Information</h3>
    <p class="email-text">
        <strong>{{ $order->customer_name }}</strong><br>
        {{ $order->shipping_address }}<br>
        {{ $order->city }}, {{ $order->postal_code }}<br>
        Phone: {{ $order->customer_phone }}
    </p>
    
    <div style="text-align: center; margin-top: 40px;">
        <a href="{{ route('home') }}" class="btn btn-gold">Shop More</a>
    </div>
    
    <div class="divider"></div>
    
    <p class="email-text" style="text-align: center; color: #6b7280; font-size: 14px;">
        We'll notify you as soon as your order ships. If you have any questions, feel free to contact us.
    </p>
@endsection
