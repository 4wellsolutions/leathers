<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta_title', config('app.name', 'Leathers.pk') . ' - Premium Handcrafted Leather Goods')</title>
    <meta name="description"
        content="@yield('meta_description', 'Shop premium handcrafted leather belts, wallets, and watches at Leathers.pk. Genuine leather products with lifetime warranty. Free shipping on orders over Rs. 5,000.')">
    <meta name="keywords"
        content="@yield('meta_keywords', 'leather belts, leather wallets, leather watches, genuine leather, handcrafted leather, premium leather goods, pakistan')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:title"
        content="@yield('og_title', View::hasSection('meta_title') ? View::getSection('meta_title') : config('app.name', 'Leathers.pk') . ' - Premium Handcrafted Leather Goods')">
    <meta property="og:description"
        content="@yield('og_description', View::hasSection('meta_description') ? View::getSection('meta_description') : 'Shop premium handcrafted leather belts, wallets, and watches at Leathers.pk.')">
    <meta property="og:image" content="@yield('og_image', asset('/images/hero/hero.png'))">
    <meta property="og:site_name" content="{{ config('app.name', 'Leathers.pk') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title"
        content="@yield('twitter_title', View::hasSection('meta_title') ? View::getSection('meta_title') : config('app.name', 'Leathers.pk') . ' - Premium Handcrafted Leather Goods')">
    <meta name="twitter:description"
        content="@yield('twitter_description', View::hasSection('meta_description') ? View::getSection('meta_description') : 'Shop premium handcrafted leather belts, wallets, and watches at Leathers.pk.')">
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
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Custom Header Scripts -->
    {!! \App\Models\Setting::get('header_scripts') !!}
</head>

<body class="font-sans text-neutral-900 antialiased bg-neutral-50 flex flex-col min-h-screen">

    @include('partials.header')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('partials.footer')

    @include('partials.sticky-cart-footer')

    <!-- Custom Footer Scripts -->
    {!! \App\Models\Setting::get('footer_scripts') !!}
    <!-- Floating WhatsApp Button -->
    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/923111222741" target="_blank" rel="noopener noreferrer"
        class="fixed bottom-6 right-6 z-[100] bg-[#25D366] hover:bg-[#20bd5a] text-white p-3 rounded-full shadow-lg transition-transform hover:scale-110 flex items-center justify-center group"
        aria-label="Chat on WhatsApp">
        <span
            class="absolute right-full mr-3 bg-white text-neutral-800 text-xs font-bold px-3 py-1.5 rounded-lg shadow-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
            Chat with us
        </span>
        <!-- Official WhatsApp Icon -->
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.008-.57-.008-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.506 2.135.93 2.957.9 4.026.793 1.185-.119 2.073-.854 2.37-1.68.297-.825.297-1.536.208-1.684-.089-.149-.287-.208-.584-.356zM12 21.782c-5.405 0-9.782-4.377-9.782-9.782 0-2.358.851-4.526 2.271-6.223L3.333 2l5.968 1.564C10.126 3.12 11.048 2.972 12 2.972c5.405 0 9.782 4.377 9.782 9.782 0 5.405-4.377 9.782-9.782 9.782z" />
        </svg>
    </a>

</body>

</html>