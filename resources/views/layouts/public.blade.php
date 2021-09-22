<div class="grid-container">
    <div class="menu-icon" @click="onClick">
        <i class="fas fa-bars"></i>
    </div>
    <header class="header">
        <div class="header__left">
            <x-header-navigation />
        </div>
        <div class="header__right">
            <a href="{{ route('login') }}">Login</a>
        </div>
    </header>

    <aside class="sidenav">
    </aside>

    <main class="main">
        @yield('main')
    </main>

    <footer class="footer">
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

