<div class="grid-container @if(!$guard)public @endif">
	<div class="menu-icon">
		<i class="fas fa-bars"></i>
	</div>

	@section('header')
		<header @if(!$guard)class="public"@endif>
			@if($guard)
				<x-header-navigation :guard="$guard"/>
			@else
				<nav class="navbar fixed-top navbar-expand bg-transparent white mt-0">
					<div class="container-fluid">
						<x-public-top-navbar/>
						<ul class="navbar-nav ms-auto mb-2 mb-lg-0 mt-0">
							<li class="nav-item">
								<a class="" href="{{ route('admin.login') }}" title="Admin Login">
									<i class="fa-solid fa-screwdriver-wrench me-1"></i>
									<span class="d-none d-md-inline-block">Admin-Login</span>
								</a>
							</li>
							<li class="nav-item ms-3">
								<a class="" href="{{ route('customer.login') }}" title="Kunden-Login">
									<i class="fas fa-user me-1"></i>
									<span class="d-none d-md-inline-block">Kunden-Login</span>
								</a>
							</li>
							<li class="nav-item ms-3">
								<a class="" href="{{ route('register') }}" title="Kunden-Registrierung">
									<i class="fa-regular fa-address-card me-1"></i>
									<span class="d-none d-md-inline-block">Registrierung</span>
								</a>
							</li>
						</ul>
					</div>
				</nav>
			@endif
		</header>
	@show

	@if($guard)
	<aside class="sidenav">
		<div class="sidebar-navigation">
			<div class="hidden md:inline-block app-logo"><span>port</span><span>m</span></div>
			<x-sidebar :guard="$guard" />
			<div class="ms-3 mt-0">
				<x-form method="post" class="mt-0" name="frmLogout" action="{{ route($guard . '.logout') }}">
					@csrf
					<x-form-submit class="btn btn-sm btn-light mt-0" icon="fas fa-sign-out-alt">Logout</x-form-submit>
				</x-form>
			</div>
		</div>
	</aside>
	@endif

	<main>
		@yield('main-full')
		<div class="m-sm-2 m-md-3">
			@yield('main')
		</div>
	</main>

	<footer>
		@guest()
			<x-public-bottom-navbar />
		@elseguest()
			@yield('footer')
		@endguest
	</footer>
</div>
