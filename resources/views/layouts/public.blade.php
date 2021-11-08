<div class="grid-container public">
    <!--div class="menu-icon">
        <i class="fas fa-bars"></i>
    </div-->
    <header class="header">
        <div class="header__left">
            @if(! app()->environment(['production']))
                <span class="text-lg text-red-700">{{ DB::getDefaultConnection() }}</span>
            @endif
            <x-header-navigation />
        </div>
        <div class="header__right">
            @auth('customer')
                <x-form method="post" class="hidden md:inline-block" name="frmLogout" action="{{ route('customer.logout') }}">
                    @csrf
                    <span class="hidden md:inline clear-none">{{ auth('customer')->user()->name }}</span>
                    <x-form-submit inline class="ml-2" icon="fas fa-sign-out-alt">
                        <span class="hidden md:inline">Logout</span>
                    </x-form-submit>
                </x-form>
            @else
                <a href="{{ route('customer.login') }}">Kunden-Login</a>
            @endif
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
