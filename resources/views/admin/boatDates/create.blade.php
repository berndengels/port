@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link href="{{ route('admin.boatDates.index', ['saison' => $modus ?? null]) }}" icon="fas fa-backward"
                    class="btn">zurück
        </x-nav-link>
        <x-form name="frm" method="post" action="{{ route('admin.boatDates.store') }}" class="w-full lg:w-1/2">

            <x-form-select class="calc" class="boat" id="boat_id" name="boat_id" label="Boot" :options="$boatOptions"
                           required/>
            <x-form-select class="calc" id="modus" name="modus" label="Art" :options="$datesModi" required/>

            <x-form-input class="calc" id="from" name="from" type="date" label="Von" required/>
            <x-form-input class="calc" id="until" name="until" type="date" label="Bis" required/>

            <div class="mt-3">
                <x-form-checkbox class="calc" name="crane" label="Kranen"/>
            </div>
            <div class="mt-3">
                <x-form-checkbox class="calc" name="mast_crane" label="Mast kranen"/>
            </div>
            <div class="mt-3">
                <x-form-checkbox class="calc" name="cleaning" label="Rumpf-Reinigung"/>
            </div>
            <!--x-form-input class="calc" name="special_price" label="eigener Preis" /-->
            <x-form-input id="price" name="price" type="number" min="0" label="Gesamt-Preis" required/>
            <x-form-input type="hidden" name="prices"/>

            <x-form-input id="length" name="length" type="number" min="0" label="Länge" disabled/>
            <x-form-input id="width" name="width" type="number" min="0" step="0.1" label="Breite" disabled/>
            <x-form-input id="weight" name="weight" type="number" min="0" label="Gewicht in Kg" disabled/>
            <x-form-input id="mast_length" name="mast_length" type="number" min="0" label="Mastlänge" disabled/>
            <x-form-input id="mast_weight" name="mast_weight" type="number" min="0" label="Mastgewicht in Kg" disabled/>

            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">
                    Speichern
                </x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

@push('inline-scripts')
    <script>
        const defaultFromWinter = "{{ $defaultFromWinter }}",
            defaultUntilWinter  = "{{ $defaultUntilWinter }}",
	        defaultFromSummer   = "{{ $defaultFromSummer }}",
	        defaultUntilSummer  = "{{ $defaultUntilSummer }}";

		$(document).ready(() => {
			const priceCalcUrl = "{{ route('admin.boatDates.price.calculate') }}",
				autofillParams = {
					length: document.frm.length,
					width: document.frm.width,
					weight: document.frm.weight,
					mast_length: document.frm.mast_length,
					mast_weight: document.frm.mast_weight,
				};
			let val = $('.boat').val();
			if (val) {
				MyForm.autofill("/admin/boats/" + val, autofillParams);
			}
			$('#modus').change(e => {
				console.info(e.target.value);
				switch(e.target.value) {
					case 'summer':
						$('#from').val(defaultFromSummer);
						$('#until').val(defaultUntilSummer);
						break;
					case 'winter':
						$('#from').val(defaultFromWinter);
						$('#until').val(defaultUntilWinter);
						break;
                }
            });
			$('.boat').on('change', e => {
				let val = e.target.value;
				if (val && "" !== val) {
					MyForm.autofill("/admin/boats/" + val, autofillParams);
				}
			});
			Prices.boatDates.calculate(document.frm, priceCalcUrl);
		})
    </script>
@endpush
