<ul class="navbar-nav me-auto mb-2 mb-lg-0 mt-0">
	<li title="Dashboard" class="navbar-brand align-middle">
		<span class="d-none d-lg-inline-block white">DEMO</span>
		<a class="app-logo public" href="/dashboard">
			<span>port</span>
			<span>m</span>
		</a>
	</li>

	@if($offers['Boat'])
		<!--li title="Boote" class="nav-item align-middle">
        <a class="nav-link" href="#">
            <i class="fas fa-ship me-1"></i>
            <span class="d-none d-md-inline-block">Boote</span>
        </a>
    </li-->
	@endif

	@if($offers['Caravan'])
		<!--li title="Caravans" class="nav-item align-middle">
        <a class="nav-link" href="#">
            <i class="fas fa-caravan me-1"></i>
            <span class="d-none d-md-inline-block">Caravans</span>
        </a>
    </li-->
	@endif

	@if($offers['Houseboat'] || $offers['House'] || $offers['Apartment'])
		<li title="Hausboote" class="nav-item align-middle">
			<a class="nav-link" href="{{ route('public.rentals.reservation') }}">
				<i class="fas fa-house-user me-1"></i>
				<span class="d-none d-md-inline-block">Vermietung</span>
			</a>
		</li>
	@endif

	@if($offers['Service'])
		<!--li title="Services" class="nav-item align-middle">
        <a class="nav-link" href="#">
            <i class="fa-brands fa-servicestack"></i>
            <span class="d-none d-md-inline-block">Services</span>
        </a>
    </li-->
	@endif

</ul>
