@if($floating) <div class="form-floating"> @endif

    @if(!$floating)
        <x-form-label :label="$label" :for="$attributes->get('id') ?: $id()" />
        @isset($help)
            <i class="fa-solid fa-circle-question fs-6 help"></i>
        @endisset
    @endif

    <textarea
        @if($isWired())
            wire:model{!! $wireModifier() !!}="{{ $name }}"
        @endif

        name="{{ $name }}"

        @if($label && !$attributes->get('id'))
            id="{{ $id() }}"
        @endif

        {{--  Placeholder is required as of writing  --}}
        @if($floating && !$attributes->get('placeholder'))
            placeholder="&nbsp;"
        @endif

        {!! $attributes->merge(['class' => 'form-control' . ($hasError($name) ? ' is-invalid' : '')]) !!}
    >@unless($isWired()){!! $value !!}@endunless</textarea>

    @if($floating)
        <x-form-label :label="$label" :for="$attributes->get('id') ?: $id()" />
    @endif

@if($floating) </div> @endif

@if($hasErrorAndShow($name))
    <x-form-errors :name="$name" />
@endif
