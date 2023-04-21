<div class="items-center justify-between {{ $attributes['inline'] ? 'inline-flex' : 'mt-6 flex' }}"
     {!! $attributes->merge([
        'inline' => isset($attributes['inline']) ? true : false,
    ]) !!}
>
    <button {!! $attributes->merge([
        'class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline',
        'type'  => 'submit',
        'icon'  => isset($attributes['icon']) ? $attributes['icon'] : '',
    ])
    !!}>
        @if(isset($attributes['icon']))
            <i class="{{ $attributes['icon'] }}"></i>
        @endif
        {!! trim($slot) ?: __('Submit') !!}
    </button>
</div>
