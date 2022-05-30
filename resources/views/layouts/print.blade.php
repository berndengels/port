<!doctype html>
<html>
<head>
    <title>{{ __('Print Ansicht') }}</title>
    <meta charset="utf-8">
    <!--meta name="viewport" content="width=device-width, initial-scale=1"/-->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <!-- Fonts -->
    {{-- Loads IBM Plex Mono --}}
    @googlefonts('poppins')
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @stack('styles')
<!-- Scripts -->
    @auth('admin')
        <script src="{{ mix('js/app-admin.js') }}"></script>
    @else
        <script src="{{ mix('js/app.js') }}"></script>
    @endauth
    @stack('scripts')
</head>
<body class="print">
<div class="grid-container @guest public @endguest">
    <main class="main">
        @yield('main')
    </main>
</div>
@stack('inline-scripts')
</body>
</html>
