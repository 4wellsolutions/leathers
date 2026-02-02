@extends('emails.layouts.master')

@section('title', 'Order En Route - ' . $order->order_number)

@section('content')
    <h1 class="h1">🚚 Your Selection has Departed!</h1>
    <p class="p">Hello {{ $order->customer_name }}, <br> Great news! Your premium leather selection has officially departed
        our workshop and is now gracefully making its way to your doorstep.</p>

    <!-- Shipping Overview -->
    <div class="info-card" style="background-color: #F8F9FA; border-left-color: #007bff;">
        <div class="info-title">Status</div>
        <div class="info-value" style="color: #007bff;">En Route to Destination</div>
        <div class="info-title" style="margin-top: 15px;">Expected Arrival</div>
        <div class="info-value">{{ now()->addDays(3)->format('M d') }} — {{ now()->addDays(5)->format('M d, Y') }}</div>
    </div>

    @if($order->tracking_number ?? false)
        <div
            style="background-color: #FDFCFB; border: 1px dashed #C5A359; border-radius: 12px; padding: 25px; margin: 30px 0; text-align: center;">
            <div class="info-title">Tracking Identity</div>
            <div style="font-size: 24px; font-weight: 700; color: #2D1B14; letter-spacing: 2px; margin: 10px 0;">
                {{ $order->tracking_number }}
            </div>
            <p class="p" style="font-size: 13px; margin-bottom: 0;">Use this identifier with our delivery partner to trace your
                package.</p>
        </div>
    @endif

    <h2 style="font-size: 18px; font-weight: 700; color: #2D1B14; margin-bottom: 20px;">Shipping To</h2>
    <div class="info-card" style="background-color: #ffffff; border: 1px solid #EAE2D8; border-left: 4px solid #C5A359;">
        <div class="address-text" style="color: #5C4A42; font-size: 15px; line-height: 1.8;">
            <strong>{{ $order->customer_name }}</strong><br>
            {{ $order->shipping_address }}<br>
            {{ $order->city }}<br>
            Phone: {{ $order->customer_phone }}
        </div>
    </div>

    <div class="divider"></div>

    <div class="divider"></div>

    <h3 style="font-size: 18px; font-weight: 700; color: #2D1B14; margin-bottom: 20px;">Items Traced</h3>
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
        @foreach($order->items as $item)
            <tr>
                <td style="padding: 15px 0; border-bottom: 1px solid #F8F5F2;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="60">
                                <img src="{{ $item->image_url }}"
                                    style="width: 50px; height: 50px; border-radius: 4px; object-fit: cover;"
                                    alt="{{ $item->product_name }}">
                            </td>
                            <td style="text-align: left; padding-left: 15px;">
                                <div style="font-size: 14px; font-weight: 600; color: #2D1B14;">{{ $item->product_name }}</div>
                                <div style="font-size: 12px; color: #888;">Qty: {{ $item->quantity }}</div>
                            </td>
                            <td style="text-align: right; font-weight: 700; color: #C5A359;">
                                Rs. {{ number_format($item->subtotal) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        @endforeach
    </table>

    <div
        style="background-color: #FDFCFB; padding: 25px; border-radius: 12px; border: 1px solid #EAE2D8; text-align: center;">
        <div class="info-title" style="margin-bottom: 10px;">Care Tip</div>
        <p class="p" style="font-size: 14px; margin-bottom: 0; font-style: italic;">
            "To maintain the natural luster of your leather, keep it away from direct sunlight and store it in a cool, dry
            place."
        </p>
    </div>

    <div class="btn-container">
        <a href="{{ route('home') }}" class="btn">DISCOVER MORE CRAFTS</a>
    </div>

    <p class="p" style="font-size: 14px; opacity: 0.7; text-align: center;">
        We'll send a final notification once your package has been delivered.
    </p>
@endsection