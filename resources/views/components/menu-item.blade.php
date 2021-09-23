<li class="sidenav__list-item {{ $class }}">
        @if($route)
            <a class="btn w-full @if(\Illuminate\Support\Facades\Route::current()->getName() === $route) active @endif" href="{{ route($routePrefix.'.route.current', ['current' => $name,'route' => $route]) }}">
                @if($icon)
                    <i class="{{ $icon }}"></i>
                @endif
                <span>{{ $name }}</span>
            </a>
        @else
            <a class="btn w-full @if(\Illuminate\Support\Facades\Route::current()->getName() === $name) active @endif" href="{{ route($routePrefix.'.route.current', ['current' => $name,'route' => null]) }}">
                @if($icon)
                    <i class="{{ $icon }}"></i>
                @endif
                <span>{{ $name }}</span>
            </a>
        @endif
</li>
