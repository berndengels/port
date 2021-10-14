@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.boats.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form name="frm" method="post" :action="route('admin.boatDates.update', $boatDate)" class="w-full lg:w-1/2">
            @method('put')
            @bind($boatDate)
            <x-form-select class="calc" name="boat_id" label="Boot" :options="$boatOptions" required />
            <x-form-select class="calc" name="modus" label="Art" :options="$datesModi" required />

            <x-form-input class="calc" name="from" type="date" label="Von" :bind="false" :default="$boatDate->validFrom" required />
            <x-form-input class="calc" name="until" type="date" label="Bis" :bind="false" :default="$boatDate->validUntil" required />

            <div class="mt-3">
                <x-form-checkbox class="calc" name="crane" label="Kranen" :bind="false" :default="$boatDate->isCraned" />
            </div>
            <div class="mt-3">
                <x-form-checkbox class="calc" name="mast_crane" label="Mast kranen" :bind="false" :default="$boatDate->isMastCraned" />
            </div>
            <div class="mt-3">
                <x-form-checkbox class="calc" name="cleaning" label="Rumpf-Reinigung" :bind="false" :default="$boatDate->isCleaned" />
            </div>
            <x-form-input class="calc" name="default_price" label="eigener Preis" />
            <x-form-input name="price" label="Gesamt-Preis" required />
            <x-form-input type="hidden" name="prices" />
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
		    const calcUrl = "{{ route("admin.boatDates.price.calculate") }}";
		    Prices.boatDates.calculate(document.frm, calcUrl);
	    })
    </script>
@endpush
