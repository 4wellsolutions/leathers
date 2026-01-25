<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Leathers.pk')</title>
    <style>
        /* Reset & Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #1a1a1a;
            background-color: #f5f5f5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Container */
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #f5f5f5;
            padding: 20px 0;
        }

        .email-container {
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        }

        /* Header */
        .email-header {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .email-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><path d="M0 100 C 20 0 50 0 100 100 Z" fill="%23d4af37" opacity="0.05"/></svg>');
            background-size: cover;
        }

        .email-header-content {
            position: relative;
            z-index: 1;
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 3px;
            color: #d4af37;
            text-decoration: none;
            display: inline-block;
            font-family: 'Playfair Display', Georgia, serif;
        }

        .header-subtitle {
            color: #ffffff;
            font-size: 14px;
            margin-top: 8px;
            opacity: 0.9;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* Content */
        .email-content {
            padding: 40px 30px;
        }

        .email-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 16px;
            font-family: 'Playfair Display', Georgia, serif;
        }

        .email-text {
            font-size: 16px;
            color: #4a5568;
            line-height: 1.7;
            margin-bottom: 16px;
        }

        /* Order Info Box */
        .info-box {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border-left: 4px solid #d4af37;
            padding: 20px;
            margin: 24px 0;
            border-radius: 8px;
        }

        .info-box-title {
            font-size: 14px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .info-box-value {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
        }

        /* Product Items */
        .product-items {
            margin: 30px 0;
        }

        .product-item {
            display: flex;
            align-items: flex-start;
            padding: 20px;
            margin-bottom: 16px;
            background-color: #fafafa;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            margin-right: 16px;
            flex-shrink: 0;
        }

        .product-details {
            flex: 1;
        }

        .product-name {
            font-weight: 600;
            font-size: 16px;
            color: #1a1a1a;
            margin-bottom: 6px;
            display: block;
        }

        .product-meta {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .product-price {
            font-weight: 700;
            color: #d4af37;
            font-size: 16px;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid #1a1a1a;
            box-shadow: 0 4px 12px rgba(26, 26, 26, 0.2);
        }

        .btn-gold {
            background: linear-gradient(135deg, #d4af37 0%, #c99f2e 100%);
            border-color: #d4af37;
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: #1a1a1a;
            border: 2px solid #1a1a1a;
            box-shadow: none;
        }

        .btn-block {
            display: block;
            width: 100%;
        }

        /* Order Summary */
        .order-summary {
            background-color: #fafafa;
            border-radius: 8px;
            padding: 24px;
            margin: 30px 0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 15px;
        }

        .summary-row.total {
            border-top: 2px solid #d4af37;
            margin-top: 12px;
            padding-top: 16px;
            font-weight: 700;
            font-size: 18px;
            color: #1a1a1a;
        }

        .summary-label {
            color: #6b7280;
        }

        .summary-value {
            font-weight: 600;
            color: #1a1a1a;
        }

        /* Footer */
        .email-footer {
            background-color: #1a1a1a;
            padding: 30px;
            text-align: center;
        }

        .footer-text {
            color: #9ca3af;
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 12px;
        }

        .footer-link {
            color: #d4af37;
            text-decoration: none;
            font-weight: 500;
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        .social-links {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #374151;
        }

        .social-link {
            display: inline-block;
            margin: 0 8px;
            color: #d4af37;
            text-decoration: none;
            font-size: 13px;
        }

        /* Divider */
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e5e7eb, transparent);
            margin: 30px 0;
        }

        /* Responsive */
        .email-wrapper {
            padding: 10px;
        }

        .email-header {
            padding: 30px 20px;
        }

        .email-content {
            padding: 20px 15px;
        }

        .email-title {
            font-size: 22px;
        }

        /* Keep product item side-by-side on mobile for better density */
        .product-item {
            padding: 15px;
        }

        .product-image {
            width: 70px;
            height: 70px;
            margin-right: 12px;
        }

        .product-name {
            font-size: 15px;
        }

        .btn {
            padding: 12px 24px;
            font-size: 15px;
            width: 100%;
            text-align: center;
        }
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Header -->
            <div class="email-header">
                <div class="email-header-content">
                    <a href="{{ url('/') }}" class="logo">LEATHERS.PK</a>
                    <div class="header-subtitle">Premium Leather Goods</div>
                </div>
            </div>

            <!-- Content -->
            <div class="email-content">
                @yield('content')
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <p class="footer-text">
                    &copy; {{ date('Y') }} Leathers.pk. All rights reserved.
                </p>
                <p class="footer-text">
                    Questions? Contact us at <a href="mailto:hello@leathers.pk"
                        class="footer-link">hello@leathers.pk</a>
                </p>

                @if(\App\Models\Setting::get('social_facebook') || \App\Models\Setting::get('social_instagram'))
                    <div class="social-links">
                        @if($fb = \App\Models\Setting::get('social_facebook'))
                            <a href="{{ $fb }}" class="social-link">Facebook</a>
                        @endif
                        @if($ig = \App\Models\Setting::get('social_instagram'))
                            <a href="{{ $ig }}" class="social-link">Instagram</a>
                        @endif
                        @if($twitter = \App\Models\Setting::get('social_twitter'))
                            <a href="{{ $twitter }}" class="social-link">Twitter</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>

</html>