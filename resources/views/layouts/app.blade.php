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
    [
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "Leathers.pk",
            "url": "{{ url('/') }}",
            "logo": "{{ asset('/images/hero/hero.png') }}",
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+92-311-1222741",
                "contactType": "customer service",
                "areaServed": "PK",
                "availableLanguage": ["English", "Urdu"]
            },
            "sameAs": [
                "{{ \App\Models\Setting::get('facebook_url', 'https://facebook.com/leatherspk') }}",
                "{{ \App\Models\Setting::get('instagram_url', 'https://instagram.com/leatherspk') }}",
                "https://wa.me/923111222741"
            ]
        },
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "Leathers.pk",
            "url": "{{ url('/') }}",
            "potentialAction": {
                "@type": "SearchAction",
                "target": "{{ url('/search') }}?q={search_term_string}",
                "query-input": "required name=search_term_string"
            }
        }
    ]
    </script>

    <!-- Favicon -->
    @if(\App\Models\Setting::get('site_favicon'))
        <link rel="icon" type="image/x-icon" href="{{ \App\Models\Setting::get('site_favicon') }}">
        <link rel="apple-touch-icon" href="{{ \App\Models\Setting::get('site_favicon') }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        <link rel="apple-touch-icon" href="{{ asset('favicon.ico') }}">
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

    @unless(request()->is('admin*') || (auth()->check() && auth()->user()->is_admin))
        <!-- Meta Pixel Code -->
        <script>
            !function (f, b, e, v, n, t, s) {
                if (f.fbq) return; n = f.fbq = function () {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = '2.0';
                n.queue = []; t = b.createElement(e); t.async = !0;
                t.src = v; s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '818025517364350');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id=818025517364350&ev=PageView&noscript=1" /></noscript>
        <!-- End Meta Pixel Code -->

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-17950154997"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());
            gtag('config', 'AW-17950154997');
            gtag('config', 'G-FC07HY5793');
        </script>
    @endunless
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
        class="fixed bottom-6 right-6 z-[100] transition-transform hover:scale-110 flex items-center justify-center group"
        aria-label="Chat on WhatsApp">
        <span
            class="absolute right-full mr-3 bg-white text-neutral-800 text-xs font-bold px-3 py-1.5 rounded-lg shadow-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
            Chat with us
        </span>
        <!-- Official WhatsApp Icon with Tail -->
        <svg class="w-14 h-14 text-[#25D366]" viewBox="0 0 16 16" fill="currentColor"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
        </svg>
    </a>

    @stack('scripts')

</body>

</html>