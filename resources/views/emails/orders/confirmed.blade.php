@extends('emails.layouts.master')

@section('title', 'Order Confirmed - ' . $order->order_number)

@section('content')
    <h1 class="h1">✅ Your Order is Confirmed!</h1>
    <p class="p">Hello {{ $order->customer_name }}, <br> Great news! We've confirmed your order. Our master artisans are now
        meticulously crafting your selection to ensure it meets our highest standards of excellence.</p>

    <!-- Estimated Delivery -->
    <div class="info-card" style="background-color: #FFFDF5; border-left-color: #C5A359;">
        <div class="info-title">Status</div>
        <div class="info-value" style="color: #28a745;">Meticulously Preparing Your Goods</div>
        <div class="info-title" style="margin-top: 15px;">Estimated Delivery</div>
        <div class="info-value">{{ now()->addDays(5)->format('M d') }} — {{ now()->addDays(7)->format('M d, Y') }}</div>
    </div>

    <!-- Details -->
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
        <tr>
            <td width="50%" style="padding-right: 10px;">
                <div class="info-card">
                    <div class="info-title">Order Ref</div>
                    <div class="info-value">#{{ $order->order_number }}</div>
                </div>
            </td>
            <td width="50%" style="padding-left: 10px;">
                <div class="info-card">
                    <div class="info-title">Customer Contact</div>
                    <div class="info-value">{{ $order->customer_phone }}</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <h3 style="font-size: 18px; font-weight: 700; color: #2D1B14; margin-bottom: 20px;">Order Details</h3>
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

    <p class="p" style="font-size: 14px; text-align: center; font-style: italic;">
        "Every piece of leather tells a story. We're honored to be part of yours."
    </p>

    <div class="btn-container">
        <a href="{{ route('home') }}" class="btn">VIEW OUR LATEST ARRIVALS</a>
    </div>

    <p class="p" style="font-size: 14px; opacity: 0.7; text-align: center;">
        We will notify you the moment your order departs our workshop.
    </p>
@endsection