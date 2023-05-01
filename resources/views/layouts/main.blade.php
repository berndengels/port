<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!--base href="/"-->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="cache-control" content="max-age=0">
    <meta http-equiv="cache-control" content="no-cache">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/fav/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/fav/favicon-16x16.png">
    <link rel="manifest" href="/fav/site.webmanifest">
    <link rel="preload" as="image" href="{{ asset('img/nebel_morgen_opt.jpg') }}">
    <link rel="preload" as="font">
    <!-- Fonts -->
    @googlefonts('poppins')
    <!-- Styles -->
    @auth()
        <link rel="stylesheet" href="{{ mix('css/app-admin.css') }}">
    @else
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @endauth
    @stack('styles')
<!-- Scripts -->
    @stack('scripts')
    @auth()
        <script src="{{ mix('js/app-admin.js') }}"></script>
    @else
        <script src="{{ mix('js/app.js') }}"></script>
    @endauth
</head>
<body class="@stack('bodyCss')">
    <x-flash-message />
    <x-content />
    @stack('inline-scripts')
</body>
</html>
