<div class="mt-0 p-0">
    @if(! app()->environment(['production']) && config('port.main.show.env'))
        <div class="m-2">
            <span class="text-lg text-yellow-400">{{ DB::getDefaultConnection() }}</span>
        </div>
    @endif
    <ul class="sidenav__list left-menu">
        @foreach($items as $name => $item)
            @if($item)
                @if(isset($item['route']) || (isset($item['items']) && is_array($item['items']) && count($item['items']) > 0 ))
                    <x-menu-item
                        :name="$name"
                        :route="$item['items'][0]['route'] ?? $item['route']"
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
            @endif
        @endforeach
</ul>
</div>
