<li class="sidenav__list-item {{ $class }}">
    <a class="btn w-full @if($currentRouteName === $route) active @endif"
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
