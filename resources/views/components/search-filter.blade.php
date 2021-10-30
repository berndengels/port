<div>
    <x-form class="inline-form ml-5 {{ $css ?: '' }}" :method="$method" :action="$action">
        @bind($$name)
        @if ($options)
            <x-form-select
                    :name="$name"
                    :label="$label"
                    :options="$options"
                    :placeholder="$placeholder"
                    onchange="this.parent('form').submit()"
            />
        @else
            <x-form-input
                    :name="$name"
                    :label="$label"
                    :placeholder="$placeholder"
            />
            <x-form-submit class="btn" name="submit">Suche</x-form-submit>
        @endif
        @endbind
    </x-form>
</div>
