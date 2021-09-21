<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body class="font-sans antialiased" data-root="http://webapiv2.navionics.com/dist/webapi/images">

<div class="grid-container">
    <div class="menu-icon" @click="onClick">
        <i class="fas fa-bars"></i>
    </div>
    <header>
    </header>

    <aside>
    </aside>

    <main>
        @yield('main')
    </main>
    <footer>
    </footer>
</div>

</body>
</html>
