@extends('emails.layouts.master')

@section('title', 'Order Delivered - ' . $order->order_number)

@section('content')
    <div style="text-align: center;">
        <h1 class="h1">✨ It's Home!</h1>
        <p class="p">Hello {{ $order->customer_name }}, <br> We're delighted to confirm that your premium leather selection
            has been successfully delivered. We hope it exceeds every expectation of quality and craftsmanship.</p>
    </div>

    <!-- Delivered Status -->
    <div class="info-card" style="background-color: #F0FDF4; border-left-color: #28a745; text-align: center;">
        <div class="info-title">Status</div>
        <div class="info-value" style="color: #166534; font-size: 18px;">Delivered Successfully</div>
        <div class="info-value" style="color: #666; font-size: 13px; margin-top: 5px;">Order #{{ $order->order_number }}
        </div>
    </div>

    <div
        style="background: linear-gradient(135deg, #2D1B14 0%, #4A2C21 100%); padding: 40px 30px; border-radius: 16px; margin: 40px 0; text-align: center; color: #FDFCFB;">
        <div style="font-size: 24px; font-weight: 700; color: #C5A359; margin-bottom: 12px; letter-spacing: 1px;">
            SHARE YOUR THOUGHTS
        </div>
        <p class="p" style="color: rgba(253, 252, 251, 0.8); font-size: 15px; margin-bottom: 25px; line-height: 1.7;">
            Our artisans pour their soul into every stitch. Your feedback is the bridge between our workshop and your
            satisfaction.
        </p>

        <table width="100%" cellpadding="0" cellspacing="0">
            @foreach($order->items as $item)
                <tr>
                    <td style="padding: 15px 0; border-bottom: 1px solid rgba(253, 252, 251, 0.1);">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="60">
                                    <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : url($item->product->image) }}"
                                        style="width: 50px; height: 50px; border-radius: 4px; object-fit: cover;"
                                        alt="{{ $item->product_name }}">
                                </td>
                                <td style="text-align: left; padding-left: 15px;">
                                    <div style="font-size: 14px; font-weight: 600; color: #FDFCFB;">{{ $item->product_name }}
                                    </div>
                                </td>
                                <td style="text-align: right;">
                                    @if($item->product)
                                        <a href="{{ route('products.show', $item->product->slug) }}#reviews"
                                            style="background-color: #C5A359; color: #2D1B14; text-decoration: none; padding: 8px 15px; border-radius: 4px; font-size: 12px; font-weight: 700; text-transform: uppercase;">Review</a>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="divider"></div>

    <h2 style="font-size: 18px; font-weight: 700; color: #2D1B14; margin-bottom: 20px;">Leather Longevity</h2>
    <div style="background-color: #F8F5F2; padding: 30px; border-radius: 12px; border-left: 4px solid #C5A359;">
        <div class="info-title" style="margin-bottom: 15px;">Care Guidelines</div>
        <ul style="margin: 0; padding-left: 20px; color: #5C4A42; font-size: 14px; line-height: 2;">
            <li>Gently wipe with a soft, dry cloth after use.</li>
            <li>Condition every 4 months to maintain suppleness.</li>
            <li>Avoid prolonged exposure to moisture or high heat.</li>
            <li>Store in the provided dust bag when not in use.</li>
        </ul>
    </div>

    <div class="divider"></div>

    <div style="text-align: center; margin-bottom: 40px;">
        <h3 style="font-size: 16px; font-weight: 700; color: #2D1B14; margin-bottom: 10px;">Need Assistance?</h3>
        <p class="p" style="font-size: 14px;">If your order is anything less than perfect, our concierge team is here to
            help.</p>
        <a href="mailto:hello@leathers.pk"
            style="color: #C5A359; font-weight: 600; text-decoration: none; font-size: 14px; border-bottom: 1px dashed #C5A359;">Contact
            Our Concierge</a>
    </div>

    <div class="btn-container">
        <a href="{{ route('home') }}" class="btn">DISCOVER NEW ARRIVALS</a>
    </div>
@endsection