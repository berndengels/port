@if($inline) <div class="form-floating"> @endif
<select name="{{ $name }}" id="{{ $name }}"
{!! $attributes->merge([
        'class' => 'filter form-select form-select-sm h-auto p-2'
            . (!$inline ? ' mt-1' : '')
            . ($inline ? ' d-inline-block d-inline-flex' : '')
            . ($class ? ' '.$class : ''),
]) !!}
>
    @forelse($options as $key => $option)
        <option value="{{ $key }}" @if($isSelected($key)) selected="selected" @endif>
            {{ $option }}
        </option>
    @empty
        {!! $slot !!}
    @endforelse
</select>
@if($inline) </div> @endif
