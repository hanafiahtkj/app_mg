<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Meta SEO -->
        <meta name="title" content="{{ config('app.name', 'Laravel') }}">
        <meta name="description" content="Infinite Gold">
        <meta name="robots" content="index, follow">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="language" content="English">
        <meta name="author" content="Infinite Gold">

        <!-- Social media share -->
        <meta property="og:title" content=Infinite Gold>
        <meta property="og:site_name" content=Infinite Gold>
        <meta property="og:url" content={{ route('index') }}/>
        <meta property="og:description" content=Infinite Gold>
        <meta property="og:type" content="">
        <meta property="og:image" content={{ asset('assets/img/Construction-cuate.png') }}>
        <meta name="twitter:card" content="Infinite Gold" />
        <meta name="twitter:site" content="Infinite Gold" />
        <meta name="twitter:creator" content="Infinite Gold" />

        <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/3aa20d5756.js" crossorigin="anonymous"></script>

        @if (!Str::startsWith(Route::currentRouteName(), 'admin.'))
            <!-- Styles -->
            <link rel="stylesheet" href="{{ asset('vendor/finapp/assets/css/style.css') }}">
            <link rel="manifest" href="{{ asset('vendor/finapp/__manifest.json') }}">
            <style type="text/css">
                body.dark-mode {
                    background-color: #292c2d;
                    max-width: 36rem;
                    margin: 0px auto;
                }
                #app {
                    max-width: 36rem;
                    margin: 0px auto;
                    background-color: rgb(34, 35, 40);
                }
                .appHeader {
                    max-width: 36rem;
                    margin: 0px auto;
                }
                .appBottomMenu {
                    max-width: 36rem;
                    margin: 0px auto;
                }
            </style>

            <!-- Scripts -->
            <!-- Bootstrap -->
            <script src="{{ asset('vendor/finapp/assets/js/lib/bootstrap.bundle.min.js') }}"></script>
            <!-- Ionicons -->
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
            <!-- Splide -->
            <script src="{{ asset('vendor/finapp/assets/js/plugins/splide/splide.min.js') }}"></script>
            <!-- Base Js File -->
            {{-- <script src="{{ asset('vendor/finapp/assets/js/base.js') }}"></script> --}}

            <script>
                // Add to Home with 2 seconds delay.
                // AddtoHome("2000", "once");
            </script>
        @else
            <!-- Styles -->
            <link href="{{ asset('vendor/mazer/assets/compiled/css/app.css') }}" rel="stylesheet"  />
            <link rel=stylesheet href=https://cdn.jsdelivr.net/npm/pretty-print-json@2.0/dist/css/pretty-print-json.css>

            <!-- Scripts -->
            <script src="{{ asset('vendor/mazer/assets/extensions/jquery/jquery.min.js') }}" crossorigin="anonymous" defer></script>
            <script src="{{ asset('vendor/mazer/assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}" crossorigin="anonymous" defer></script>
            <script src="{{ asset('vendor/mazer/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}" crossorigin="anonymous" defer></script>
            <script src="{{ asset('vendor/mazer/assets/extensions/Select-1.7.0/js/dataTables.select.min.js') }}" crossorigin="anonymous" defer></script>
            <script src="{{ asset('vendor/mazer/assets/extensions/flatpickr/flatpickr.min.js') }}" crossorigin="anonymous" defer></script>
            <script src="{{ asset('vendor/mazer/assets/extensions/flatpickr/plugins/monthSelect/index.js') }}" crossorigin="anonymous" defer></script>
            <script src="{{ asset('vendor/mazer/assets/extensions/choices.js/public/assets/scripts/choices.js') }}" crossorigin="anonymous" defer></script>
            <script src="{{ asset('vendor/mazer/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}" crossorigin="anonymous" defer></script>
            <script src="{{ asset('vendor/mazer/assets/compiled/js/app.js') }}" crossorigin="anonymous" defer></script>

            <script src=https://cdn.jsdelivr.net/npm/pretty-print-json@2.0/dist/pretty-print-json.min.js></script>
        @endif

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased dark-mode">
        @inertia
    </body>
</html>
