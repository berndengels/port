<div class="@if($inline) inline-flex @else mt-2 @endif">
    <label class="@if($inline) inline-flex @endif">
        <x-form-label :label="$label" />
        <select
            @if($isWired())
                wire:model{!! $wireModifier() !!}="{{ $name }}"
            @endif

            name="{{ $name }}"

            @if($multiple)
                multiple
            @endif

            {!! $attributes->merge([
                'class' => (!$multiple ? 'h-10' : '')  . (($label && !$inline) ? ' mt-1' : '')
                    . ($inline ? ' inline-flex' : ' block w-full')
//                    . (($label && $inline) ? ' sm:block sm:w-full' : '')
                    . ($class ? ' '.$class : ''),
            ]) !!}>
            @forelse($options as $key => $option)
                <option value="{{ $key }}" @if($isSelected($key)) selected="selected" @endif>
                    {{ __($option) }}
                </option>
            @empty
                {!! $slot !!}
            @endforelse
        </select>
        @if($help)
            <i data-info="{{ $help }}" class="help text-xl text-blue-900 right-auto ml-2 fas fa-question-circle"></i>
        @endif
    </label>

    @if($hasErrorAndShow($name))
        <x-form-errors :name="$name" />
    @endif
</div>
