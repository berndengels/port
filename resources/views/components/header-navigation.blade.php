<ul class="top-menu">
    @if(!isset($items['route']) && isset($items['items']) && count($items['items']) > 0)
        @foreach($items['items'] as $item)
            @can($item['permissions'])
            <li title="{{ $item['text'] }}" class="ml-3 @if(Route::current()->getName() === $item['route']) active @endif">
                <a href="{{ route($item['route']) }}">
                    @if($item['icon'])
                        <i class="{{ $item['icon'] }}"></i>
                    @endif
                    <span class="hidden md:inline-block">
                        {{ $item['text'] }}
                    </span>
                </a>
            </li>
            @endcan
        @endforeach
    @endif
</ul>
