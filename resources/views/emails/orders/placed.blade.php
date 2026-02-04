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

    <div class="product-items" style="margin: 15px 0;">
        <table width="100%" cellpadding="0" cellspacing="0">
            @foreach($order->items as $item)
                <tr>
                    <td style="padding: 15px 0; border-bottom: 1px solid #eee;">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="100" valign="top">
                                    <img src="{{ $item->image_url }}" alt="{{ $item->product_name }}"
                                        style="width: 80px; height: 80px; border-radius: 8px; object-fit: cover; border: 1px solid #eee;">
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    {{-- Product Name --}}
                                    <div
                                        style="font-weight: 600; font-size: 15px; color: #1a1a1a; margin-bottom: 6px; line-height: 1.4;">
                                        {{ $item->product_name }}
                                    </div>

                                    {{-- Variant Pill --}}
                                    @if($item->variant && $item->variant->color)
                                        <div style="margin-bottom: 8px;">
                                            <span
                                                style="background-color: #f3f4f6; color: #6b7280; padding: 4px 8px; border-radius: 4px; font-size: 12px; display: inline-block;">
                                                Color family: {{ $item->variant->color->name }}
                                            </span>
                                        </div>
                                    @endif

                                    {{-- Price and Qty Row --}}
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="font-weight: 700; font-size: 15px; color: #1a1a1a;">
                                                Rs. {{ number_format($item->price) }}
                                            </td>
                                            <td align="right" style="font-weight: 600; font-size: 14px; color: #1a1a1a;">
                                                Qty: {{ $item->quantity }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            @endforeach
        </table>
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