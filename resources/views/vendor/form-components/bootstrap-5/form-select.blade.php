
    @if($label)
        <label class="form-label @isset($inline) inline @else mt-2 @endisset" :for="$attributes->get('id') ?: $id()">{{ $label }}</label>
        @isset($help)
            <!--i class="fa-solid fa-circle-question fs-4 d-inline help" data-info="{{ $help }}"></i-->
        @endisset
    @endif

    <select
        @if($isWired())
            wire:model{!! $wireModifier() !!}="{{ $name }}"
        @endif

        name="{{ $name }}"

        @if($multiple)
            multiple
        @endif

        @if($label && !$attributes->get('id'))
            id="{{ $id() }}"
        @endif

        {!! $attributes->merge([
                'class' => 'form-select' . ($hasError($name) ? ' is-invalid' : '')
                    . (!$multiple ? ' h-10' : '')
                    . (isset($inline) ? ' inline' : '')
                    . (isset($class) ? ' '.$class : ''),
            ]) !!}
    >
    @if($options)
        @forelse($options as $key => $option)
            <option value="{{ $key }}" @if($isSelected($key)) selected="selected" @endif>
                {{ $option }}
            </option>
        @empty
            {!! $slot !!}
        @endforelse
    @endif
    </select>

@if($hasErrorAndShow($name))
    <x-form-errors :name="$name" />
@endif
