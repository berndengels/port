<nav class="navbar navbar-expand fixed-bottom bg-transparent white">
    <div class="container-fluid">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 mt-1 pb-0">
            <li class="nav-item" title="Impressum">
                <a class="nav-link align-middle" href="{{ route('public.pages','impressum') }}">
                    <i class="fa-regular fa-building"></i>
                    <span class="d-none d-md-inline-block ms-1">Impressum</span>
                </a>
            </li>
            <li class="nav-item align-middle" title="Datenschutzerklärung">
                <a class="nav-link" href="{{ route('public.pages','datenschutz') }}">
                    <i class="fa-solid fa-hands-holding-circle"></i>
                    <span class="d-none d-md-inline-block ms-1">Datenschutzerklärung</span>
                </a>
            </li>
            <li class="nav-item align-middle" title="Kontakt-Anfrage">
                <a class="nav-link" href="{{ route('public.contacts.create') }}">
                    <i class="fas fa-at"></i>
                    <span class="d-none d-md-inline-block ms-1">Kontakt</span>
                </a>
            </li>
            <li class="nav-item align-middle" title="Kontakt-Anfrage">
                <a class="nav-link" href="{{ route('public.documentation') }}">
                    <i class="fas fa-at"></i>
                    <span class="d-none d-md-inline-block ms-1">Dokumentation</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
