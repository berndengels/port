<div class="mt-5">
    <ul class="sidenav__list">
        @foreach($items as $name => $item)
            @if(isset($item['route']))
                <x-menu-item :name="$name" route="{{ $item['route'] }}" />
            @else
                <x-menu-item :name="$name" />
            @endif
        @endforeach
    </ul>
</div>
