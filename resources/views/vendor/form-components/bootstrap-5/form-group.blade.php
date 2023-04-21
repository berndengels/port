<div {!! $attributes->merge(['class' => ($hasError($name) ? 'is-invalid' : '')]) !!}>
    @if($label)
        <label class="form-label">{!! $label !!}</label>
    @endif

    <!--div class="@if($inline) d-flex flex-row flex-wrap inline-space @endif"-->
    <div class="@if($inline) d-inline-block @endif">
        {!! $slot !!}
    </div>

    {!! $help ?? null !!}

    @if($hasErrorAndShow($name))
        <x-form-errors :name="$name" class="d-block" />
    @endif
</div>
