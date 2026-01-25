<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #FDFCFB;
            color: #2D1B14;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .wrapper {
            width: 100%;
            background-color: #FDFCFB;
            table-layout: fixed;
            padding: 40px 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(45, 27, 20, 0.05);
        }

        .header {
            background: linear-gradient(135deg, #2D1B14 0%, #4A2C21 100%);
            padding: 50px 40px;
            text-align: center;
        }

        .logo {
            width: 180px;
            margin: 0 auto 15px;
        }

        .logo-text {
            font-size: 32px;
            font-weight: 700;
            color: #C5A359;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .header-tagline {
            color: #FDFCFB;
            font-size: 13px;
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
            opacity: 0.8;
        }

        .content {
            padding: 50px 40px;
        }

        .h1 {
            font-size: 28px;
            font-weight: 700;
            color: #2D1B14;
            margin: 0 0 20px;
            line-height: 1.3;
        }

        .p {
            font-size: 16px;
            color: #5C4A42;
            margin: 0 0 25px;
        }

        .btn-container {
            text-align: center;
            margin: 35px 0;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #C5A359 0%, #A6853A 100%);
            color: #ffffff !important;
            text-decoration: none;
            padding: 16px 45px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 1px;
            box-shadow: 0 8px 20px rgba(197, 163, 89, 0.3);
            transition: all 0.3s ease;
        }

        .info-card {
            background-color: #F8F5F2;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            border-left: 4px solid #C5A359;
        }

        .info-title {
            font-size: 12px;
            font-weight: 700;
            color: #C5A359;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .info-value {
            font-size: 15px;
            font-weight: 600;
            color: #2D1B14;
        }

        .footer {
            padding: 40px;
            text-align: center;
            background-color: #2D1B14;
            color: #FDFCFB;
        }

        .footer-logo {
            font-size: 20px;
            font-weight: 700;
            color: #C5A359;
            letter-spacing: 2px;
            margin-bottom: 20px;
        }

        .footer-links {
            margin-bottom: 25px;
        }

        .footer-link {
            color: #FDFCFB;
            text-decoration: none;
            font-size: 13px;
            margin: 0 10px;
            opacity: 0.7;
        }

        .footer-text {
            font-size: 12px;
            opacity: 0.5;
            font-weight: 300;
        }

        .divider {
            border: 0;
            border-top: 1px solid #EAE2D8;
            margin: 40px 0;
        }

        @media screen and (max-width: 600px) {
            .content {
                padding: 40px 25px;
            }

            .h1 {
                font-size: 24px;
            }

            .header {
                padding: 40px 25px;
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <!-- Header -->
            <div class="header" style="padding: 0; background: none;">
                <img src="{{ $message->embed(public_path('images/email-header.png')) }}" alt="LEATHERS.PK"
                    style="width: 100%; height: auto; display: block; border-top-left-radius: 16px; border-top-right-radius: 16px;">
            </div>

            <!-- Content Area -->
            <div class="content">
                @yield('content')
            </div>

            <!-- Footer -->
            <div class="footer">
                <div class="footer-logo">LEATHERS.PK</div>
                <div class="footer-links">
                    <a href="{{ url('/') }}" class="footer-link">Home</a>
                    <a href="{{ url('/products') }}" class="footer-link">Products</a>
                    <a href="{{ url('/contact-us') }}" class="footer-link">Contact</a>
                </div>
                <div class="footer-text">
                    &copy; {{ date('Y') }} Leathers.pk. All Rights Reserved.<br>
                    Crafting premium leather goods with passion and precision.
                </div>
            </div>
        </div>
    </div>
</body>

</html>