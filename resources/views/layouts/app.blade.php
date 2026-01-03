<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta_title', config('app.name', 'Leathers.pk') . ' - Premium Handcrafted Leather Goods')</title>
    <meta name="description" content="@yield('meta_description', 'Shop premium handcrafted leather belts, wallets, and watches at Leathers.pk. Genuine leather products with lifetime warranty. Free shipping on orders over Rs. 5,000.')">
    <meta name="keywords" content="@yield('meta_keywords', 'leather belts, leather wallets, leather watches, genuine leather, handcrafted leather, premium leather goods, pakistan')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:title" content="@yield('og_title', View::hasSection('meta_title') ? View::getSection('meta_title') : config('app.name', 'Leathers.pk') . ' - Premium Handcrafted Leather Goods')">
    <meta property="og:description" content="@yield('og_description', View::hasSection('meta_description') ? View::getSection('meta_description') : 'Shop premium handcrafted leather belts, wallets, and watches at Leathers.pk.')">
    <meta property="og:image" content="@yield('og_image', asset('/images/hero/hero.png'))">
    <meta property="og:site_name" content="{{ config('app.name', 'Leathers.pk') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', View::hasSection('meta_title') ? View::getSection('meta_title') : config('app.name', 'Leathers.pk') . ' - Premium Handcrafted Leather Goods')">
    <meta name="twitter:description" content="@yield('twitter_description', View::hasSection('meta_description') ? View::getSection('meta_description') : 'Shop premium handcrafted leather belts, wallets, and watches at Leathers.pk.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('/images/hero/hero.png'))">

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Organization",
        "name": "Leathers.pk",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('/images/hero/hero.png') }}",
        "description": "Premium handcrafted leather goods including belts, wallets, and watches",
        "address": {
            "@@type": "PostalAddress",
            "addressCountry": "PK"
        },
        "sameAs": [
            "https://facebook.com/leatherspk",
            "https://instagram.com/leatherspk"
        ]
    }
    </script>
    
    <!-- Favicon -->
    @if(\App\Models\Setting::get('site_favicon'))
        <link rel="icon" type="image/x-icon" href="{{ \App\Models\Setting::get('site_favicon') }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-CjNtKzmC.css') }}">
    <script src="{{ asset('build/assets/app-BJonE_Nf.js') }}" defer></script>
    <!-- Custom Header Scripts -->
    {!! \App\Models\Setting::get('header_scripts') !!}
</head>
<body class="font-sans text-neutral-900 antialiased bg-neutral-50 flex flex-col min-h-screen">
    
    @include('partials.header')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Custom Footer Scripts -->
    {!! \App\Models\Setting::get('footer_scripts') !!}
</body>
</html>
