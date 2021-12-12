<ul class="top-menu">
    @if(!isset($currentRoutes['route']) && isset($currentRoutes['items']) && count($currentRoutes['items']) > 0)
        @foreach($currentRoutes['items'] as $item)
            @if(!isset($item['permissions']) || ( isset($item['permissions']) /*&& auth($guard)->user()->can($item['permissions'])*/) )
                <li title="{{ $item['title'] }}" class="ml-3 @if($currentRouteName === $item['route'] || (isset($subRoutes[$item['route']]) && $subRoutes[$currentTopRouteName]->contains($currentRouteName))) active @endif">
                <a href="{{ route($item['route']) }}">
                    @if($item['icon'])
                        <i class="{{ $item['icon'] }}"></i>
                    @endif
                    <span class="hidden md:inline-block">
                        {{ $item['text'] }}
                    </span>
                </a>
            </li>
            @endif
        @endforeach
    @endif
</ul>
