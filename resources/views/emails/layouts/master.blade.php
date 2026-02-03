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
            background-color: #111111;
            padding: 40px 20px;
            text-align: center;
        }

        .logo-text {
            font-size: 28px;
            font-weight: 700;
            color: #C5A359;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 5px;
            font-family: 'Playfair Display', serif;
        }

        .header-tagline {
            color: #ffffff;
            font-size: 11px;
            font-weight: 400;
            letter-spacing: 2px;
            text-transform: uppercase;
            opacity: 0.8;
        }

        .footer {
            padding: 40px 20px;
            text-align: center;
            background-color: #111111;
            color: #C5A359;
        }

        .footer-logo {
            font-size: 20px;
            font-weight: 700;
            color: #C5A359;
            letter-spacing: 2px;
            margin-bottom: 20px;
            font-family: 'Playfair Display', serif;
        }

        .footer-link {
            color: #C5A359;
            text-decoration: none;
            font-size: 13px;
            margin: 0 10px;
            opacity: 0.8;
        }

        .footer-link:hover {
            opacity: 1;
            text-decoration: underline;
        }

        .footer-text {
            font-size: 12px;
            color: #999999;
            margin-top: 20px;
        }

        /* ... existing styles ... */
    </style>
    @yield('styles')
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <!-- Header -->
            <div class="header">
                <div class="logo-text">LEATHERS.PK</div>
                <div class="header-tagline">Premium Leather Goods</div>
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