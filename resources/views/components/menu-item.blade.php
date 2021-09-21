<li class="sidenav__list-item">
    @if(isset($icon))
        <i :class="$icon"></i>
    @endif
    <span>
        @if($route)
            <!--a class="btn" href="{{ route($route) }}">{{ $name }}</a-->
            <a class="btn" href="{{ route('route.current', ['current' => $name,'route' => $route]) }}">{{ $name }}</a>
        @else
            <a class="btn" href="{{ route('route.current', ['current' => $name,'route' => null]) }}">{{ $name }}</a>
        @endif
    </span>
</li>
