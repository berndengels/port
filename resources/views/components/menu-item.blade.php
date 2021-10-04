<li class="sidenav__list-item {{ $class }}">
    @php
        $routePrefix = auth()->check() ? 'admin' : 'public'
    @endphp
    <a class="btn w-full @if(session()->get('currentName') === $name) active @endif"
       href="{{ route($routePrefix.'.route.current', ['current' => $name, 'route' => $route ?? null]) }}">
        @if($icon)
            <i class="{{ $icon }}"></i>
        @endif
        <span>{{ $name }}</span>
    </a>
</li>
