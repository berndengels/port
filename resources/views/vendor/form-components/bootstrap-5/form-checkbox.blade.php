<div class="form-check @if(null !== $attributes->get('switch')) form-switch @endif @if(null !== $attributes->get('inline')) form-check-inline @endif">
    <input
        {!! $attributes->merge([
	        'class' => 'form-check-input '
	        . (isset($class) ? $class : '')
	        . ($hasError($name) ? ' is-invalid' : '')
	    ]) !!}

        type="checkbox"

        value="{{ $value }}"

        @if($isWired())
            wire:model{!! $wireModifier() !!}="{{ $name }}"
        @endif

        name="{{ $name }}"

        @if($label && !$attributes->get('id'))
            id="{{ $id() }}"
        @endif

        @if($checked)
            checked="checked"
        @endif
    />
    @isset($help)
        <i class="fa-solid fa-circle-question fs-6 help" data-info="{{ $help }}"></i>
    @endisset

    <label {!! $attributes->merge([
            'class' => 'form-check-label ' . $class
            . ($inline ? ' inline' : 'mt-2')
            ]) !!} :for="$attributes->get('id') ?: $id()">
        {!! $label !!}
    </label>

    @if($hasErrorAndShow($name))
        <x-form-errors :name="$name" />
    @endif
</div>
