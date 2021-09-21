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
    @stack('extra-styles')
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    @stack('extra-scripts')
</head>
<body class="font-sans antialiased" data-root="http://webapiv2.navionics.com/dist/webapi/images">

<div class="grid-container">
    <div class="menu-icon" onclick="onMenuIconClick()">
        <i class="fas fa-bars"></i>
    </div>

    <header class="header">
        <div class="header__left">
            <x-header-navigation />
        </div>
        <div class="header__right">
            Login
        </div>
    </header>

    <aside class="sidenav">
        <div class="sidenav__close-icon" onclick="onCloseIconClick()">
            <i class="fas fa-times"></i>
        </div>

        <x-admin-main-navigation />
    </aside>

    <main class="main">
        @yield('main')
    </main>

    <footer class="footer">
        @yield('footer')
    </footer>
</div>

@section('inline-scripts')
    <script>
		//        $(document).ready(function() {
		const sideNav = document.querySelector('.sidenav');
		function onMenuIconClick() {
			addClass(sideNav,'active')
		}
		function onCloseIconClick()  {
			alert('close');
			removeClass(sideNav,'active')
		}
		//        });
    </script>
@show
</body>
</html>
