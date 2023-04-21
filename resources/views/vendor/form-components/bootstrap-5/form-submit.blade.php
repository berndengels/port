<button
    {!! $attributes->merge([
        'class' => 'btn ' . $attributes['class'],
        'type' => 'submit',
        'icon'  => isset($attributes['icon']) ? $attributes['icon'] : '',
    ]) !!}
>
    @if(isset($attributes['icon']))
        <i class="{{ $attributes['icon'] }}"></i>
    @endif
    {!! trim($slot) ?: __('Submit') !!}
</button>
