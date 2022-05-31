@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.caravanDates.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>

        <x-form name="frm" method="post" action="{{ route('admin.caravanDates.store') }}" class="w-full lg:w-1/2 mt-5">
			<x-form-checkbox id="is_paid" name="is_paid" label="Ist Bezahlt" class="mb-0 pb-0" />
            <x-form-input name="prices" type="hidden" />
			<x-form-input id="carnumber" name="carnumber" type="text" label="Kennzeichen" autocomplete="off" required />
			<ul class="hidden w-full autocomplete"></ul>
			<x-form-select id="country_id" name="country_id" label="Herkunftsland" :options="$countries" default="{{ config('port.main.default.country_id') }}" />
			<x-form-input id="carlength" name="carlength" label="Länge" required />
			<x-form-input id="email" type="email" name="email" label="Email" />

			<x-form-input class="calc" id="from" name="from" type="date" label="Von" required />
			<x-form-input class="calc" id="until" name="until" type="date" label="Bis" required />
			<div class="mt-3">
				<x-form-checkbox class="calc" name="electric" label="Stromanschluß" />
			</div>
			<x-form-input class="calc" type="number" step="1" min="1" name="persons" label="Anzahl Personen" required />
			<!--x-form-input class="calc" name="special_price" label="Spezial Preis" /-->
			<x-form-input type="number" id="price" name="price" min="0" label="Gesamt-Preis" required />
			<div class="mt-2">
				<x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
			</div>
        </x-form>
    </div>
@endsection

@push('inline-scripts')
    <script>
		$(document).ready(() => {
			const calcUrl = "{{ route('admin.caravanDates.price.calculate') }}",
					frm = document.frm,
					options = {!! $caravanOptions !!},
					bindings = {
						carnumber: frm.carnumber,
						carlength: frm.carlength,
						country_id: frm.country_id,
						email: frm.email,
					};
			MyForm.autocomplete(".autocomplete", frm.carnumber, options, 'carnumber', bindings);
			Prices.caravanDates.calculate(document.frm, calcUrl);
		})
    </script>
@endpush
