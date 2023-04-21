@extends('layouts.main')

@section('main')
    <div>
        <x-btn-back route="{{ route('admin.boatDates.index', ['saison' => $modus ?? null]) }}" />
        <div class="mt-2">
            <span class="text-xl text-blue-900">Boot: {{ $boatDate->boat->name }} ({{ __($boatDate->modus) }})</span>
        </div>
        <x-form name="frm" method="post" :action="route('admin.boatDates.update', $boatDate)" class="w-half mt-3">
            @method('put')
            @bind($boatDate)
            <x-form-checkbox id="is_paid" name="is_paid" label="Ist Bezahlt" class="mb-0 pb-0" />
            <x-form-input  class="calc" type="hidden" name="modus" required />
            <x-form-input  class="calc" type="hidden" name="boat_id" required />
            <x-form-input class="calc" id="modus" name="modus" label="Saison" readonly />
            <x-form-input class="calc" id="from" name="from" type="date" label="Von" :bind="false" default="{{ $boatDate->validFrom }}" required />
            <x-form-input class="calc" id="until" name="until" type="date" label="Bis" :bind="false" default="{{ $boatDate->validUntil }}" required />

            @if($priceComponents->count() > 0)
                @foreach($priceComponents as $pc)
                    <div class="mt-3">
                        <x-form-checkbox class="calc" id="{{ $pc->key }}" name="{{ $pc->key }}" label="{{ $pc->name }}" default="{{ $pc->{'has'.Str::ucfirst($pc->key)} }}"/>
                    </div>
                @endforeach
            @endif
            <br>
            <x-form-input id="price" name="price" type="number" min="0" label="Gesamt-Preis" required />
            <x-form-input type="hidden" name="prices" />
            @endbind
            @bind($boatDate->boat)
            <x-form-input id="length" name="length" type="number" step="0.1" min="0" label="Länge" disabled />
            <x-form-input id="width" name="width" type="number" step="0.1" min="0" label="Breite" disabled />
            <x-form-input id="weight" name="weight" type="number" step="100" min="0" label="Gewicht in Kg" disabled />
            <x-form-input id="mast_length" name="mast_length" type="number" step="0.1" min="0" label="Mastlänge" disabled />
            <x-form-input id="mast_weight" name="mast_weight" type="number" step="1" min="0" label="Mastgewicht in Kg" disabled />
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
    const calcUrl = "{{ route('admin.boatDates.price.calculate') }}";
    Prices.calculate(document.frm, calcUrl);
});
</script>
@endpush
