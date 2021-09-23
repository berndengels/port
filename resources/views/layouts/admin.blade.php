
<div class="grid-container">
    <div class="menu-icon">
        <i class="fas fa-bars"></i>
    </div>

    <header class="header">
        <div class="header__left">
            <x-header-navigation />
        </div>
        <div class="header__right">
            <x-form method="post" name="frmLogout" action="{{ route('logout') }}">
                @csrf
                <span onclick="document.frmLogout.submit()">{{ auth()->user()->name }} <span class="btn ml-2">Logout</span></span>
            </x-form>
        </div>
    </header>

    <aside class="sidenav">
        <div class="sidenav__close-icon">
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

@stack('inline-scripts')
