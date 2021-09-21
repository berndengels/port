<ul class="top-menu">
    @foreach($items as $item)
        <li>
            @if($item['icon'])
                <i class="{{ $item['icon'] }}"></i>
            @endif
            <a href="{{ route($item['route']) }}">{{ $item['text'] }}</a>
        </li>
    @endforeach
</ul>
