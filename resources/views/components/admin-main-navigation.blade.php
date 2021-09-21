<div>
    <ul class="list-none">
        @foreach($items as $name => $item)
            <x-menu-item :name="$name" />
        @endforeach
    </ul>
</div>
