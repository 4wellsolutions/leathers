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