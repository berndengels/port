<ul class="top-menu">
    @if(!isset($items['route']) && isset($items['items']) && count($items['items']) > 0)
        @foreach($items['items'] as $item)
            <li title="{{ $item['text'] }}" class="ml-3">
                <a href="{{ route($item['route']) }}">
                    @if($item['icon'])
                        <i class="{{ $item['icon'] }}"></i>
                    @endif
                    <span class="hidden md:inline-block">
                        {{ $item['text'] }}
                    </span>
                </a>
            </li>
        @endforeach
    @endif
</ul>
