
<div class="grid-container">
    <div class="menu-icon">
        <i class="fas fa-bars"></i>
    </div>

    <header class="header">
        <div class="header__left">
            <x-header-navigation />
        </div>
        <div class="header__right">
            @auth('admin')
            <x-form method="post" class="hidden md:inline-block" name="frmLogout" action="{{ route('admin.logout') }}">
                @csrf
                <span class="hidden md:inline clear-none">{{ auth('admin')->user()->name }}</span>
                <x-form-submit inline class="ml-2" icon="fas fa-sign-out-alt">
                    <span class="hidden md:inline">Logout</span>
                </x-form-submit>
            </x-form>
            @endauth
        </div>
    </header>

    <aside class="sidenav">
        <div class="sidenav__close-icon">
            <i class="fas fa-times"></i>
        </div>
        <x-admin-main-navigation />
        <div class="ml-3 mt-0">
            <x-form method="get" class="mt-0" name="frmLogout" action="{{ route('admin.logout') }}">
                @csrf
                <x-form-submit class="mt-0" icon="fas fa-sign-out-alt">
                    Logout
                </x-form-submit>
            </x-form>
        </div>
    </aside>

    <main class="main">
        @yield('main')
    </main>

    <footer class="footer">
        @yield('footer')
    </footer>

</div>
