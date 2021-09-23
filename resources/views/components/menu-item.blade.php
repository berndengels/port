<li class="sidenav__list-item {{ $class }}">
        @if($route)
            <a class="btn w-full @if(session()->get('currentName') === $name) active @endif" href="{{ route($routePrefix.'.route.current', ['current' => $name,'route' => $route]) }}">
                @if($icon)
                    <i class="{{ $icon }}"></i>
                @endif
                <span>{{ $name }}</span>
            </a>
        @else
            <a class="btn w-full @if(session()->get('currentName') === $name) active @endif" href="{{ route($routePrefix.'.route.current', ['current' => $name,'route' => null]) }}">
                @if($icon)
                    <i class="{{ $icon }}"></i>
                @endif
                <span>{{ $name }}</span>
            </a>
        @endif
</li>
