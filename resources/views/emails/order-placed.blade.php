@extends('emails.layouts.master')

@section('title', 'Order Received - ' . $order->order_number)

@section('styles')
    <style>
        .invoice-header {
            border-bottom: 2px solid #F8F5F2;
            padding-bottom: 30px;
            margin-bottom: 40px;
        }

        .invoice-title {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: #2D1B14;
            margin: 0;
            line-height: 1.2;
        }

        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #C5A359;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 15px;
            font-family: 'Outfit', sans-serif;
        }

        .order-summary-table {
            width: 100%;
            margin: 30px 0;
            border-collapse: collapse;
        }

        .order-summary-table th {
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            color: #8A7366;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px 0;
            border-bottom: 1px solid #EAE2D8;
        }

        .item-row td {
            padding: 20px 0;
            border-bottom: 1px solid #F8F5F2;
        }

        .product-name {
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            font-weight: 700;
            color: #2D1B14;
            margin-bottom: 4px;
        }

        .product-variant {
            display: inline-block;
            background-color: #2D1B14;
            color: #ffffff;
            font-size: 10px;
            text-transform: uppercase;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .totals-container {
            width: 100%;
            margin-top: 20px;
        }

        .total-row {
            padding: 8px 0;
        }

        .total-label {
            font-size: 14px;
            color: #5C4A42;
        }

        .total-value {
            font-size: 14px;
            font-weight: 600;
            color: #2D1B14;
            text-align: right;
        }

        .total-final {
            border-top: 1px solid #EAE2D8;
            padding-top: 15px;
            margin-top: 10px;
        }

        .total-final .total-label {
            font-size: 16px;
            font-weight: 700;
            color: #2D1B14;
        }

        .total-final .total-value {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            color: #C5A359;
            text-align: right;
        }
    </style>
@endsection

@section('content')
    <!-- Invoice Like Header -->
    <div class="invoice-header">
        <h1 class="invoice-title">Order Received</h1>
        <p class="p" style="margin-top: 10px; margin-bottom: 0;">Order #{{ $order->order_number }}</p>
    </div>

    <!-- Grid Layout for Address/Info -->
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 40px;">
        <tr>
            <td width="50%" valign="top" style="padding-right: 20px;">
                <div class="section-title">Bill To</div>
                <div class="p" style="margin-bottom: 0; font-size: 14px; line-height: 1.6;">
                    <strong>{{ $order->customer_name }}</strong><br>
                    {{ $order->customer_email }}<br>
                    {{ $order->customer_phone }}
                </div>
            </td>
            <td width="50%" valign="top" style="padding-left: 20px;">
                <div class="section-title">Ship To</div>
                <div class="p" style="margin-bottom: 0; font-size: 14px; line-height: 1.6;">
                    <strong>{{ $order->customer_name }}</strong><br>
                    {{ $order->shipping_address }}<br>
                    {{ $order->city }}
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">Order Details</div>

    <table class="order-summary-table">
        <thead>
            <tr>
                <th width="60%">Item Description</th>
                <th width="20%" style="text-align: center;">Qty</th>
                <th width="20%" style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr class="item-row">
                    <td>
                        <div class="product-name">{{ $item->product_name }}</div>
                        @if($item->variant_name)
                            <span class="product-variant">{{ $item->variant_name }}</span>
                        @endif
                    </td>
                    <td style="text-align: center; color: #5C4A42; font-weight: 600;">{{ $item->quantity }}</td>
                    <td style="text-align: right; color: #2D1B14; font-weight: 700;">Rs. {{ number_format($item->subtotal) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td width="50%"></td>
            <td width="50%">
                <div class="totals-container">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="total-label" style="padding-bottom: 8px;">Subtotal</td>
                            <td class="total-value" style="padding-bottom: 8px;">Rs. {{ number_format($order->subtotal) }}
                            </td>
                        </tr>
                        @if($order->discount_amount > 0)
                            <tr>
                                <td class="total-label" style="padding-bottom: 8px; color: #16a34a;">Discount
                                    @if($order->coupon_code) ({{ $order->coupon_code }}) @endif</td>
                                <td class="total-value" style="padding-bottom: 8px; color: #16a34a;">- Rs.
                                    {{ number_format($order->discount_amount) }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="total-label" style="padding-bottom: 15px;">Shipping</td>
                            <td class="total-value" style="padding-bottom: 15px;">
                                @if($order->shipping_cost == 0)
                                    FREE
                                @else
                                    Rs. {{ number_format($order->shipping_cost) }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border-top: 1px solid #EAE2D8; padding-top: 15px;"></td>
                        </tr>
                        <tr>
                            <td class="total-label" style="font-size: 16px; font-weight: 700; color: #2D1B14;">Total</td>
                            <td class="total-value"
                                style="font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 700; color: #C5A359;">
                                Rs. {{ number_format($order->total) }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <div style="text-align: center; margin-top: 50px; padding-top: 30px; border-top: 1px solid #F8F5F2;">
        <a href="{{ route('home') }}" class="btn">CONTINUE SHOPPING</a>
    </div>
@endsection