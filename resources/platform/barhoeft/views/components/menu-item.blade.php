<li id="{{ $name }}" class="sidenav__list-item align-content-start {{ $class }}">
    <a role="button" class="btn @if($currentRouteName === $route) active @else white @endif"
       href="{{ route('route.current', [
                'currentRouteName' => $name,
                'guard' => $guard,
                'route' => $route ?? null
            ]) }}">
        @if($icon)
            <i class="{{ $icon }}"></i>
        @endif
        <span>{{ $name }}</span>
    </a>
</li>
