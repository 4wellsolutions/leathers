<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Invoice') - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Work+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: white !important;
        }

        @media print {
            @page {
                margin: 0.5cm;
                size: portrait;
            }

            .no-print {
                display: none !important;
            }

            body {
                margin: 0;
                padding: 0;
                background-color: white !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .invoice-container {
                max-width: none !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
        }
    </style>
</head>

<body class="bg-white text-neutral-900 font-sans antialiased">
    <div class="invoice-container max-w-[800px] mx-auto p-6 md:p-8">
        @yield('content')
    </div>

    @yield('scripts')
</body>

</html>