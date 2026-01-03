@extends('layouts.email-base')

@section('title', 'Order Shipped - Leathers.pk')

@section('content')
    <h1 class="email-title">🚚 Your Order is On Its Way!</h1>
    
    <p class="email-text">
        Hi <strong>{{ $order->customer_name }}</strong>,
    </p>
    
    <p class="email-text">
        Exciting news! Your order has been shipped and is heading your way. You should receive it within 3-5 business days.
    </p>
    
    <div class="info-box" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-left-color: #3b82f6;">
        <div class="info-box-title" style="color: #1e40af;">🚚 SHIPPED</div>
        <div class="info-box-value" style="color: #1e40af;">{{ $order->order_number }}</div>
    </div>
    
    <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 20px; margin: 24px 0; border-radius: 8px;">
        <div style="font-size: 14px; font-weight: 600; color: #92400e; margin-bottom: 8px;">
            📅 EXPECTED DELIVERY
        </div>
        <div style="font-size: 18px; font-weight: 700; color: #92400e;">
            {{ now()->addDays(3)->format('F d') }} - {{ now()->addDays(5)->format('F d, Y') }}
        </div>
    </div>
    
    @if($order->tracking_number ?? false)
    <div style="background-color: #f5f5f5; padding: 20px; border-radius: 8px; margin: 24px 0; text-align: center;">
        <div style="font-size: 14px; color: #6b7280; margin-bottom: 8px;">Tracking Number</div>
        <div style="font-size: 20px; font-weight: 700; color: #1a1a1a; letter-spacing: 1px;">
            {{ $order->tracking_number }}
        </div>
        <a href="#" class="btn btn-outline" style="margin-top: 16px; display: inline-block;">Track Package</a>
    </div>
    @endif
    
    <div class="divider"></div>
    
    <h3 class="email-title" style="font-size: 20px;">What's in Your Package</h3>
    
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
    
    <div class="divider"></div>
    
    <h3 class="email-title" style="font-size: 20px;">Shipping To</h3>
    <p class="email-text">
        <strong>{{ $order->customer_name }}</strong><br>
        {{ $order->shipping_address }}<br>
        {{ $order->city }}, {{ $order->postal_code }}<br>
        Phone: {{ $order->customer_phone }}
    </p>
    
    <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 24px; border-radius: 8px; margin: 32px 0; text-align: center;">
        <div style="font-size: 16px; color: #92400e; margin-bottom: 8px;">💡 Pro Tip</div>
        <div style="font-size: 14px; color: #78350f; line-height: 1.6;">
            Make sure someone is available to receive your package. If you're not home, our delivery partner will leave a notice with instructions.
        </div>
    </div>
    
    <div class="divider"></div>
    
    <p class="email-text" style="text-align: center; color: #6b7280; font-size: 14px;">
        We'll send you another email once your order is delivered. Get ready to experience premium leather quality!
    </p>
@endsection
