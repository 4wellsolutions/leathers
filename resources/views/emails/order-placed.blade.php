<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }

        .header {
            background: linear-gradient(135deg, #2c1810 0%, #4a2c1a 100%);
            padding: 40px 30px;
            text-align: center;
        }

        .logo {
            font-size: 32px;
            font-weight: bold;
            color: #d4af37;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .header-subtitle {
            color: #ffffff;
            font-size: 14px;
            opacity: 0.9;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 24px;
            color: #2c1810;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .message {
            color: #666;
            margin-bottom: 30px;
            font-size: 15px;
        }

        .order-info {
            background-color: #f9f9f9;
            border-left: 4px solid #d4af37;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 4px;
        }

        .order-info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }

        .order-info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .order-info-label {
            color: #666;
            font-size: 14px;
        }

        .order-info-value {
            color: #2c1810;
            font-weight: 600;
            font-size: 14px;
        }

        .section-title {
            font-size: 18px;
            color: #2c1810;
            margin-bottom: 20px;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 2px solid #d4af37;
        }

        .product-item {
            display: flex;
            padding: 20px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 5px;
            background-color: #fff;
        }

        .product-details {
            flex: 1;
            padding-left: 20px;
        }

        .product-name {
            font-size: 15px;
            color: #2c1810;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .product-variant {
            font-size: 13px;
            color: #999;
            margin-bottom: 8px;
        }

        .product-quantity {
            font-size: 13px;
            color: #666;
        }

        .product-price {
            text-align: right;
            padding-left: 20px;
        }

        .price-value {
            font-size: 16px;
            color: #d4af37;
            font-weight: 700;
        }

        .totals {
            background-color: #f9f9f9;
            padding: 20px;
            margin-top: 30px;
            border-radius: 8px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .total-row.final {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #d4af37;
            font-size: 18px;
            font-weight: 700;
        }

        .total-label {
            color: #666;
        }

        .total-value {
            color: #2c1810;
            font-weight: 600;
        }

        .total-row.final .total-label,
        .total-row.final .total-value {
            color: #2c1810;
        }

        .shipping-badge {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .shipping-info {
            background-color: #f0f8ff;
            border: 1px solid #d4af37;
            padding: 20px;
            margin-top: 30px;
            border-radius: 8px;
        }

        .shipping-title {
            font-size: 16px;
            color: #2c1810;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .shipping-address {
            color: #666;
            font-size: 14px;
            line-height: 1.8;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #d4af37 0%, #c9a02c 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 15px 40px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 15px;
            margin: 30px 0;
            text-align: center;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        }

        .footer {
            background-color: #2c1810;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }

        .footer-text {
            font-size: 13px;
            opacity: 0.8;
            margin-bottom: 15px;
        }

        .social-links {
            margin: 20px 0;
        }

        .social-link {
            display: inline-block;
            margin: 0 10px;
            color: #d4af37;
            text-decoration: none;
            font-size: 13px;
        }

        .divider {
            height: 1px;
            background-color: #e0e0e0;
            margin: 30px 0;
        }

        @media only screen and (max-width: 600px) {
            .content {
                padding: 30px 20px;
            }

            .product-item {
                flex-direction: column;
            }

            .product-details {
                padding-left: 0;
                padding-top: 15px;
            }

            .product-price {
                text-align: left;
                padding-left: 0;
                padding-top: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">LEATHERS.PK</div>
            <div class="header-subtitle">Premium Leather Goods</div>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">Thank You for Your Order!</div>

            <div class="message">
                Hi {{ $order->customer_name }},<br><br>
                We're excited to confirm that we've received your order! Your premium leather goods are being carefully
                prepared for shipment.
            </div>

            <!-- Order Information -->
            <div class="order-info">
                <div class="order-info-row">
                    <span class="order-info-label">Order Number:</span>
                    <span class="order-info-value">{{ $order->order_number }}</span>
                </div>
                <div class="order-info-row">
                    <span class="order-info-label">Order Date:</span>
                    <span class="order-info-value">{{ $order->created_at->format('F d, Y') }}</span>
                </div>
                <div class="order-info-row">
                    <span class="order-info-label">Payment Method:</span>
                    <span class="order-info-value">Cash on Delivery</span>
                </div>
            </div>

            <!-- Order Items -->
            <div class="section-title">Order Details</div>

            @foreach($order->items as $item)
                <div class="product-item">
                    <img src="{{ asset($item->product->image) }}" alt="{{ $item->product_name }}" class="product-image">
                    <div class="product-details">
                        <div class="product-name">{{ $item->product_name }}</div>
                        @if($item->variant_name)
                            <div class="product-variant">{{ $item->variant_name }}</div>
                        @endif
                        <div class="product-quantity">Quantity: {{ $item->quantity }}</div>
                    </div>
                    <div class="product-price">
                        <div class="price-value">Rs. {{ number_format($item->price * $item->quantity) }}</div>
                    </div>
                </div>
            @endforeach

            <!-- Totals -->
            <div class="totals">
                <div class="total-row">
                    <span class="total-label">Subtotal:</span>
                    <span class="total-value">Rs. {{ number_format($order->subtotal) }}</span>
                </div>
                <div class="total-row">
                    <span class="total-label">Shipping:</span>
                    <span class="total-value">
                        @if($order->shipping_cost == 0)
                            <span class="shipping-badge">Free Shipping</span>
                        @else
                            Rs. {{ number_format($order->shipping_cost) }}
                        @endif
                    </span>
                </div>
                <div class="total-row final">
                    <span class="total-label">Total:</span>
                    <span class="total-value">Rs. {{ number_format($order->total) }}</span>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="shipping-info">
                <div class="shipping-title">Shipping Address</div>
                <div class="shipping-address">
                    {{ $order->customer_name }}<br>
                    {{ $order->shipping_address }}<br>
                    {{ $order->city }}<br>
                    Phone: {{ $order->customer_phone }}
                </div>
            </div>

            <div class="divider"></div>

            <!-- Call to Action -->
            <center>
                <a href="{{ route('home') }}" class="cta-button">Continue Shopping</a>
            </center>

            <div class="message" style="margin-top: 30px;">
                <strong>What's Next?</strong><br>
                Our team will contact you shortly to confirm your order and arrange delivery. If you have any questions,
                feel free to reach out to us.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-text">
                Thank you for choosing Leathers.pk<br>
                Your trusted source for premium leather goods
            </div>

            <div class="social-links">
                <a href="{{ route('home') }}" class="social-link">Visit Our Store</a> |
                <a href="{{ route('contact') }}" class="social-link">Contact Us</a>
            </div>

            <div class="footer-text" style="margin-top: 20px; font-size: 11px;">
                © {{ date('Y') }} Leathers.pk. All rights reserved.
            </div>
        </div>
    </div>
</body>

</html>