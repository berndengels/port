
<div class="grid-container">
    <div class="menu-icon" onclick="onMenuIconClick()">
        <i class="fas fa-bars"></i>
    </div>

    <header class="header">
        <div class="header__left">
            <x-header-navigation />
        </div>
        <div class="header__right">
            <x-form method="post" name="frmLogout" action="{{ route('logout') }}">
                @csrf
                <span onclick="document.frmLogout.submit()">{{ auth()->user()->name }} Logout</span>
            </x-form>
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
		const sideNav = document.querySelector('.sidenav');
		function onMenuIconClick() {
			addClass(sideNav,'active')
		}
		function onCloseIconClick()  {
			removeClass(sideNav,'active')
		}
    </script>
@show
