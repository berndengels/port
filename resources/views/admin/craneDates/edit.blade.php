@extends('layouts.main')

@section('main')
    <div>
        <x-btn-back route="{{ route('admin.boatDates.index', ['saison' => $modus ?? null]) }}" />
        <div class="mt-2">
            <span class="text-xl text-blue-900">Boot: {{ $boatDate->boat->name }} ({{ __($boatDate->modus) }})</span>
        </div>
        <x-form name="frm" method="post" :action="route('admin.boatDates.update', $boatDate)" class="w-half mt-3">
            @method('put')
            @bind($craneDate)
            <x-form-select class="calc" class="boat" id="cranable_type" name="cranable_type" label="Art" :options="$cranableTypeOptions"/>
            <x-form-select id="cranable_id" name="cranable_id" type="text" label="Boot" />
            <x-form-input id="crane_date" name="crane_date" type="date" label="Datum"/>
            <x-form-input id="crane_time" name="crane_time" type="time" label="Uhrzeit"/>
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

@push('inline-scripts')
<script>
$(document).ready(() => {
    const calcUrl = "{{ route('admin.boatDates.price.calculate') }}",
        handleCheck = (e) => {
            let $el = $(e.target),
                $wrapper = $el.parent().next('.durationWrapper'),
                $duratiun = $wrapper.find('.duration')
            ;

            if($wrapper.length > 0) {
                if($el.is(':checked')) {
                    $wrapper.removeClass('d-none');
                    $duratiun.removeAttr('disabled')
                } else {
                    $wrapper.addClass('d-none');
                    $duratiun.attr('disabled', true)
                }
            }
        }
    ;
    $(document).ready(() => {
        $('.calc[type="checkbox"]').change(e => {
            handleCheck(e);
        })
    });

    Prices.calculate(document.frm, calcUrl);
});
</script>
@endpush
