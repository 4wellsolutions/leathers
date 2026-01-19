@extends('emails.layouts.master')

@section('title', 'Order Received - ' . $order->order_number)

@section('styles')
    <style>
        .order-summary-table {
            width: 100%;
            margin: 25px 0;
            border-collapse: collapse;
        }

        .order-summary-table th {
            text-align: left;
            font-size: 13px;
            font-weight: 700;
            color: #C5A359;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding-bottom: 12px;
            border-bottom: 2px solid #F8F5F2;
        }

        .item-row td {
            padding: 20px 0;
            border-bottom: 1px solid #F8F5F2;
        }

        .product-img {
            width: 70px;
            height: 70px;
            border-radius: 8px;
            object-fit: cover;
            background-color: #F8F5F2;
            border: 1px solid #EAE2D8;
        }

        .product-name {
            font-size: 15px;
            font-weight: 600;
            color: #2D1B14;
            margin-bottom: 4px;
        }

        .product-meta {
            font-size: 12px;
            color: #8A7366;
        }

        .item-price {
            font-size: 15px;
            font-weight: 600;
            color: #2D1B14;
            text-align: right;
        }

        .totals-container {
            margin-top: 30px;
            background-color: #FDFCFB;
            border: 1px solid #EAE2D8;
            border-radius: 12px;
            padding: 20px;
        }

        .total-row {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .total-label {
            display: table-cell;
            font-size: 14px;
            color: #5C4A42;
        }

        .total-value {
            display: table-cell;
            text-align: right;
            font-size: 14px;
            font-weight: 600;
            color: #2D1B14;
        }

        .total-final {
            display: table;
            width: 100%;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #C5A359;
        }

        .total-final .total-label {
            font-size: 18px;
            font-weight: 700;
            color: #2D1B14;
        }

        .total-final .total-value {
            font-size: 22px;
            font-weight: 700;
            color: #C5A359;
        }

        .address-box {
            border: 1px dashed #C5A359;
            border-radius: 12px;
            padding: 20px;
            margin-top: 30px;
        }

        .address-title {
            font-size: 13px;
            font-weight: 700;
            color: #C5A359;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .address-text {
            font-size: 14px;
            color: #5C4A42;
            line-height: 1.6;
        }
    </style>
@endsection

@section('content')
    <h1 class="h1">Thank You for Your Order!</h1>
    <p class="p">Hello {{ $order->customer_name }}, <br> We've received your order and our craftsmen are already getting to
        work. Here's a brief summary of what you've selected.</p>

    <!-- Order Overview -->
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
        <tr>
            <td width="50%" style="padding-right: 10px;">
                <div class="info-card">
                    <div class="info-title">Order Number</div>
                    <div class="info-value">#{{ $order->order_number }}</div>
                </div>
            </td>
            <td width="50%" style="padding-left: 10px;">
                <div class="info-card">
                    <div class="info-title">Order Date</div>
                    <div class="info-value">{{ $order->created_at->format('M d, Y') }}</div>
                </div>
            </td>
        </tr>
    </table>

    <h2 style="font-size: 18px; font-weight: 700; color: #2D1B14; margin-bottom: 15px;">Selected Items</h2>

    <table class="order-summary-table">
        <thead>
            <tr>
                <th width="70%">Product</th>
                <th width="30%" style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr class="item-row">
                    <td>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="85" valign="top">
                                    <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : url($item->product->image) }}"
                                        class="product-img" alt="{{ $item->product_name }}">
                                </td>
                                <td valign="top">
                                    <div class="product-name">{{ $item->product_name }}</div>
                                    <div class="product-meta">
                                        @if($item->variant_name) {{ $item->variant_name }} | @endif
                                        Qty: {{ $item->quantity }}
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="item-price" valign="top">
                        Rs. {{ number_format($item->price * $item->quantity) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="totals-container">
        <div class="total-row">
            <span class="total-label">Subtotal</span>
            <span class="total-value">Rs. {{ number_format($order->subtotal) }}</span>
        </div>
        <div class="total-row">
            <span class="total-label">Shipping Handling</span>
            <span class="total-value">
                @if($order->shipping_cost == 0)
                    <span style="color: #28a745; font-weight: 700;">FREE</span>
                @else
                    Rs. {{ number_format($order->shipping_cost) }}
                @endif
            </span>
        </div>
        <div class="total-final">
            <span class="total-label">Payable Amount</span>
            <span class="total-value">Rs. {{ number_format($order->total) }}</span>
        </div>
    </div>

    <!-- Details -->
    <div class="address-box">
        <div class="address-title">Delivery Destination</div>
        <div class="address-text">
            <strong>{{ $order->customer_name }}</strong><br>
            {{ $order->shipping_address }}<br>
            {{ $order->city }}<br>
            Phone: {{ $order->customer_phone }}
        </div>
    </div>

    <div class="btn-container">
        <a href="{{ route('home') }}" class="btn">CONTINUE SHOPPING</a>
    </div>

    <div class="divider"></div>

    <h3 style="font-size: 16px; font-weight: 700; color: #2D1B14; margin-bottom: 10px;">What's Next?</h3>
    <p class="p" style="font-size: 14px; margin-bottom: 0;">Our team will contact you shortly to confirm your order and
        arrange a seamless delivery. If you have any questions in the meantime, simply reply to this email or visit our
        contact page.</p>
@endsection