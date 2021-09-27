<button {!! $attributes->merge([
    'class' => 'btn btn-primary',
    'type' => 'submit',
    'icon'  => isset($attributes['icon']) ? $attributes['icon'] : '',

]) !!}>
    @if(isset($attributes['icon']))
        <i class="{{ $attributes['icon'] }}"></i>
    @endif
    {!! trim($slot) ?: __('Submit') !!}
</button>
