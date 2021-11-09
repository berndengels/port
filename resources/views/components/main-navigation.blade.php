<div class="mt-0 p-0">
    <ul class="sidenav__list left-menu">
        @foreach($items as $name => $item)
            @if(isset($item['route']) || (isset($item['items']) && is_array($item['items']) && count($item['items']) > 0))
                <x-menu-item
                    :name="$name"
                    :route="$item['route'] ?? $item['items'][0]['route']"
                    :icon="$item['icon']"
                    :guard="$guard"
                />
            @else
                <x-menu-item
                    :name="$name"
                    :route="null"
                    :guard="$guard"
                    icon="{{ $item['icon'] }}"
                />
            @endif
@endforeach
</ul>
</div>
