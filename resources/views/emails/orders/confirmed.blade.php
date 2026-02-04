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