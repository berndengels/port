<li class="sidenav__list-item">
        @if($route)
            <a class="btn" class="{{ $class }}" href="{{ route($routePrefix.'.route.current', ['current' => $name,'route' => $route]) }}">
                @if($icon)
                    <i class="{{ $icon }}"></i>
                @endif
                <span>{{ $name }}</span>
            </a>
        @else
            <a class="btn" class="{{ $class }}" href="{{ route($routePrefix.'.route.current', ['current' => $name,'route' => null]) }}">
                @if($icon)
                    <i class="{{ $icon }}"></i>
                @endif
                <span>{{ $name }}</span>
            </a>
        @endif
</li>
