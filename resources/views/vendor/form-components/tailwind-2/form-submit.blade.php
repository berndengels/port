<div class="items-center justify-between {{ $attributes['inline'] ? 'inline-flex' : 'mt-6 flex' }}"
    {!! $attributes->merge([
       'inline' => isset($attributes['inline']) ? true : false,
   ]) !!}
>
    <button {!! $attributes->merge([
//        'class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold focus:outline-none focus:shadow-outline',
        'class' => 'btn rounded px-3',
        'type' => 'submit',
        'icon'  => isset($attributes['icon']) ? $attributes['icon'] : '',
    ]) !!}>
        @if(isset($attributes['icon']))
            <i class="{{ $attributes['icon'] }}"></i>
        @endif
        <span>{!! trim($slot) ?: __('Submit') !!}</span>
    </button>
</div>
