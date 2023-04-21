@if($inline)<div class="form-floating">@endif
    @if($label)
        <lable class="form-label" for="{{ $name }}">{{ $label }}</lable>
    @endif
    <input name="{{ $name }}" type="{{ $type ?? 'text' }}"
           @if($placeholder)
               placeholder="{{ $placeholder }}"
           @endif
           @if($label && !$attributes->get('id'))
               id="{{ $id() }}"
           @endif
           @if($default)
               value="{{ $default }}"
           @elseif($value)
               value="{{  ($type === 'color' ? '#000000' : $value) }}"
           @endif
            {!! $attributes->merge([
                    'class' => 'filter form-control h-auto p-1 ps-1'
                        . (!$inline ? ' mt-1' : '')
                        . ($inline ? ' d-inline-block d-inline-flex' : '')
                        . ($hasError($name) ? ' is-invalid' : '')
                        . ($class ? ' '.$class : ''),
            ]) !!}
    />
@if($inline) </div> @endif

@if($hasErrorAndShow($name))
    <x-form-errors name="{{ $name  }}" />
@endif
