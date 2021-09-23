<div class="mt-0 p-0">
    <ul class="sidenav__list left-menu">
        @foreach($items as $name => $item)
            @if(isset($item['route']))
                <x-menu-item :name="$name" route="{{ $item['route'] }}" icon="{{ $item['icon'] }}" />
            @else
                <x-menu-item :name="$name" icon="{{ $item['icon'] }}" />
            @endif
        @endforeach
    </ul>
</div>
