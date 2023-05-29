    @if($label)
        <!--label class="form-label @if($inline) inline @else mt-2 @endif" :for="$attributes->get('id') ?: $id()"-->
        <label {!! $attributes->merge([
            'class' => 'form-label ' . $class
            . ($inline ? ' inline' : 'mt-2')
            ]) !!} :for="$attributes->get('id') ?: $id()">
            {!! $label !!}
        </label>
    @endif
    <input
        {!! $attributes->merge([
            'class' => 'form-control ' . $class
            . ($inline ? ' inline' : '')
            . ($type === 'color' ? ' form-control-color' : '')
            . ($hasError($name) ? ' is-invalid' : '')
            ]) !!}

        type="{{ $type }}"

        @if($isWired())
            wire:model{!! $wireModifier() !!}="{{ $name }}"
        @else
            value="{{ $value ?? ($type === 'color' ? '#000000' : '') }}"
        @endif

        name="{{ $name }}"

        @if($label && !$attributes->get('id'))
            id="{{ $id() }}"
        @endif

        {{--  Placeholder is required as of writing  --}}
        @if($floating && !$attributes->get('placeholder'))
            placeholder="&nbsp;"
        @endif
    />
    @if($help)
        <!--i class="fa-solid fa-circle-question fs-4 help"></i-->
    @endif

@if($hasErrorAndShow($name))
    <x-form-errors :name="$name" />
@endif
