<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <base href="/">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
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
<!--body class="font-sans antialiased" data-root="http://webapiv2.navionics.com/dist/webapi/images"-->
<body class="font-sans antialiased">
    <x-flash-message />
    @auth('admin')
        <x-content guard="admin" />
    @elseauth('customer')
        <x-content guard="customer" />
    @else
        <x-content />
    @endauth

    @stack('inline-scripts')
    <span class="hidden">{{ config('app.env') }}</span>
</body>
</html>
