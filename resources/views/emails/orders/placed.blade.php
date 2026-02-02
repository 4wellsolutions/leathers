@extends('layouts.email-base')

@section('title', 'Order Placed - Leathers.pk')

@section('content')
    <h1 class="email-title">🎉 Thank You for Your Order!</h1>

    <p class="email-text">
        Hi <strong>{{ $order->customer_name }}</strong>,
    </p>

    <p class="email-text">
        We're thrilled to have you as a customer! Your order has been received and is being prepared with care. We'll send
        you another email once your order has been confirmed and processed.
    </p>

    <div class="info-box">
        <div class="info-box-title">Order Number</div>
        <div class="info-box-value">{{ $order->order_number }}</div>
    </div>

    <div class="info-box">
        <div class="info-box-title">Order Date</div>
        <div class="info-box-value">{{ $order->created_at->format('F d, Y') }}</div>
    </div>

    <div class="divider"></div>

    <h3 class="email-title" style="font-size: 20px;">Order Details</h3>

    <div class="product-items">
        @foreach($order->items as $item)
            <div class="product-item">
                <img src="{{ $item->image_url }}" alt="{{ $item->product_name }}" class="product-image">
                <div class="product-details">
                    <span class="product-name">{{ $item->product_name }}</span>
                    <div class="product-meta">Quantity: {{ $item->quantity }}</div>
                    <div class="product-meta">Price: <span class="product-price">Rs. {{ number_format($item->price) }}</span>
                    </div>
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
            <span>Total:</span>
            <span>Rs. {{ number_format($order->total) }}</span>
        </div>
    </div>

    <div class="divider"></div>

    <h3 class="email-title" style="font-size: 20px;">Shipping Address</h3>
    <p class="email-text">
        {{ $order->shipping_address }}<br>
        {{ $order->city }}, {{ $order->postal_code }}
    </p>

    <div style="text-align: center; margin-top: 40px;">
        <a href="{{ route('home') }}" class="btn btn-gold">Continue Shopping</a>
    </div>

    <div class="divider"></div>

    <p class="email-text" style="text-align: center; color: #6b7280; font-size: 14px;">
        You will receive a confirmation email once we verify and process your order.
    </p>
@endsection