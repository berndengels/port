
<div class="grid-container @if(!$guard)public @endif">
    <div class="menu-icon">
        <i class="fas fa-bars"></i>
    </div>

    <header class="header">
        <div class="header__left">
            @if($guard)
            <x-header-navigation :guard="$guard" />
            @endif
        </div>
        <div class="header__right">
            @if( $guard && auth($guard)->check() )
                <x-form method="post" class="hidden md:inline-block" name="frmLogout" action="{{ route($guard . '.logout') }}">
                    @csrf
                    <span class="hidden md:inline clear-none">{{ auth($guard)->user()->name }}</span>
                    <x-form-submit inline class="ml-2" icon="fas fa-sign-out-alt">
                        <span class="hidden md:inline">Logout</span>
                    </x-form-submit>
                </x-form>
            @else
            <a href="{{ route('customer.login') }}">Kunden-Login</a>
            @endif
        </div>
    </header>

    @if( $guard && auth($guard)->check() )
    <aside class="sidenav">
        <div class="sidenav__close-icon">
            <i class="fas fa-times"></i>
        </div>
        <x-main-navigation :guard="$guard" />
        <div class="ml-3 mt-0">
            <x-form method="get" class="mt-0" name="frmLogout" action="{{ route($guard . '.logout') }}">
                @csrf
                <x-form-submit class="mt-0" icon="fas fa-sign-out-alt">
                    Logout
                </x-form-submit>
            </x-form>
        </div>
    </aside>
    @endif

    <main class="main">
        @yield('main')
    </main>

    <footer class="footer">
        @yield('footer')
    </footer>

</div>
