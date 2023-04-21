<div class="@if($type === 'hidden') hidden @elseif($inline) 'inline-flex' @else mt-2 @endif">
    <label class="@if($inline) inline-flex @endif">
        <x-form-label :label="$label"/>
        <input {!! $attributes->merge([
            'class' => 'h-10' . ($inline ? ' inline-flex' : ' block w-full')
                . ' ' . ($label ? ' mt-1' : '')
//                . (($label && $inline) ? ' sm:block sm:w-full' : '')
                . ($class ? ' '.$class : ''),
            'autocomplete' => $attributes['autocomplete'] ?? '',
        ]) !!}
            @if($isWired())
                wire:model{!! $wireModifier() !!}="{{ $name }}"
            @else
                value="{{ $value }}"
            @endif
            @if(isset($attributes['autocomplete']))
               autocomplete={{ $attributes['autocomplete'] }}
            @endif
            name="{{ $name }}"
            type="{{ $type }}"
        />
        @if($help)
            <i data-info="{{ $help }}" class="help text-xl text-blue-900 right-auto ml-2 fas fa-question-circle"></i>
        @endif
    </label>

    @if($hasErrorAndShow($name))
        <x-form-errors :name="$name" />
    @endif
</div>
