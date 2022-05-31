@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link href="{{ route('admin.boatDates.index', ['saison' => $modus ?? null]) }}" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <div class="mt-5">
            <span class="text-xl text-blue-900">Boot: {{ $boatDate->boat->boat_name }} ({{ $boatDate->modus }})</span>
        </div>
        <x-form name="frm" method="post" :action="route('admin.boatDates.update', $boatDate)" class="w-full lg:w-1/2 mt-5">
            @method('put')
            @bind($boatDate)
            <x-form-checkbox id="is_paid" name="is_paid" label="Ist Bezahlt" class="mb-0 pb-0" />
            <x-form-input  class="calc" type="hidden" name="modus" required />
            <x-form-input  class="calc" type="hidden" name="boat_id" required />
            <x-form-input class="calc" id="from" name="from" type="date" label="Von" :bind="false" :default="$boatDate->validFrom" required />
            <x-form-input class="calc" id="until" name="until" type="date" label="Bis" :bind="false" :default="$boatDate->validUntil" required />

            <div class="mt-3">
                <x-form-checkbox class="calc" name="crane" label="Kranen" :bind="false" :default="$boatDate->isCraned" />
            </div>
            <div class="mt-3">
                <x-form-checkbox class="calc" name="mast_crane" label="Mast kranen" :bind="false" :default="$boatDate->isMastCraned" />
            </div>
            <div class="mt-3">
                <x-form-checkbox class="calc" name="cleaning" label="Rumpf-Reinigung" :bind="false" :default="$boatDate->isCleaned" />
            </div>
            <!--x-form-input class="calc" name="special_price" label="eigener Preis" /-->
            <x-form-input  id="price" name="price" type="number" min="0" label="Gesamt-Preis" required />
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
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

@push('inline-scripts')
    <script>
	    $(document).ready(() => {
		    const calcUrl = "{{ route('admin.boatDates.price.calculate') }}";
		    Prices.boatDates.calculate(document.frm, calcUrl);
	    })
    </script>
@endpush
