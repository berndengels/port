<div class="grid-container public">
    <!--div class="menu-icon">
        <i class="fas fa-bars"></i>
    </div-->
    <header class="header">
        <div class="header__left">
            <x-header-navigation />
        </div>
        <div class="header__right">
            <a href="{{ route('login') }}">Login</a>
        </div>
    </header>

    <!--aside class="sidenav">
        <div class="sidenav__close-icon">
            <i class="fas fa-times"></i>
        </div>
    </aside-->

    <main class="main bg-main">
        @yield('main')
    </main>

    <footer class="footer">
    </footer>
</div>
