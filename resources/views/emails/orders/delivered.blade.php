@extends('layouts.email-base')

@section('title', 'Order Delivered - ' . $order->order_number)

@section('content')
    <h1 class="email-title" style="margin-bottom: 10px;">✨ It's Home!</h1>

    <p class="email-text" style="margin-bottom: 15px;">
        Hi <strong>{{ $order->customer_name }}</strong>, your order #{{ $order->order_number }} has been delivered!
    </p>

    <div class="info-box"
        style="padding: 12px 15px; margin: 15px 0; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: 600; color: #166534;">Status: Delivered Successfully</span>
    </div>

    <div class="divider" style="margin: 20px 0;"></div>

    <h3 class="email-title" style="font-size: 18px; margin-bottom: 12px;">Rate Your Experience</h3>

    <div class="product-items" style="margin: 15px 0;">
        <table width="100%" cellpadding="0" cellspacing="0">
            @foreach($order->items as $item)
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #eee;">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="60" valign="top" style="padding-bottom: 10px;">
                                    <img src="{{ $item->image_url }}" alt="{{ $item->product_name }}" style="width: 50px; height: 50px; border-radius: 4px; object-fit: cover;">
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    <div style="font-weight: 600; font-size: 14px; color: #1a1a1a; margin-bottom: 4px;">{{ $item->product_name }}</div>
                                    <div style="font-size: 13px; color: #666; margin-bottom: 8px;">
                                        Qty: {{ $item->quantity }} | Price: <span style="font-weight: 600;">Rs. {{ number_format($item->price) }}</span>
                                    </div>
                                    @if($item->product)
                                        <div style="margin-top: 5px;">
                                            <a href="{{ route('reviews.create-for-order', $order) }}" class="btn btn-gold" style="padding: 8px 15px; font-size: 12px; white-space: nowrap; display: inline-block; text-decoration: none;">Write Review</a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="order-summary" style="padding: 15px; margin: 20px 0; border-radius: 6px;">
        <div class="summary-row" style="font-size: 14px; margin-bottom: 5px;">
            <span class="summary-label">Subtotal:</span>
            <span class="summary-value">Rs. {{ number_format($order->subtotal) }}</span>
        </div>
        <div class="summary-row" style="font-size: 14px; margin-bottom: 5px;">
            <span class="summary-label">Shipping:</span>
            <span class="summary-value">Rs. {{ number_format($order->shipping_cost) }}</span>
        </div>
        <div class="summary-row total"
            style="font-size: 16px; margin-top: 10px; padding-top: 10px; border-top: 1px solid #ddd;">
            <span>Total:</span>
            <span>Rs. {{ number_format($order->total) }}</span>
        </div>
    </div>

    <div class="divider" style="margin: 20px 0;"></div>

    <div
        style="background-color: #F8F5F2; padding: 15px; border-radius: 6px; border-left: 3px solid #C5A359; margin-bottom: 20px;">
        <div class="info-box-title" style="margin-bottom: 8px; font-size: 13px;">Quick Care Tips</div>
        <ul style="margin: 0; padding-left: 20px; color: #5C4A42; font-size: 13px; line-height: 1.5;">
            <li>Wipe with dry cloth.</li>
            <li>Condition every 4 months.</li>
            <li>Avoid water/heat.</li>
            <li>Store in dust bag.</li>
        </ul>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <p class="email-text" style="font-size: 13px; margin-bottom: 15px;">Need help? <a href="mailto:hello@leathers.pk"
                style="color: #C5A359; text-decoration: none;">Contact us</a></p>
        <a href="{{ route('home') }}" class="btn" style="padding: 10px 20px; font-size: 14px;">Shop Again</a>
    </div>
@endsection