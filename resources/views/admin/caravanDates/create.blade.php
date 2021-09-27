@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.caravanDates.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form name="frm" action="{{ route('admin.caravanDates.store') }}" class="w-full lg:w-1/2">
        @method('post')
            <x-form-input name="prices" type="hidden" />
			<x-form-input id="carnumber" name="carnumber" type="text" label="Kennzeichen" autocomplete="off" required />
			<ul id="caravans" class="hidden w-full autocomplete"></ul>
			<x-form-select id="country_id" name="country_id" label="Herkunftsland" :options="$countries" default="{{ config('port.default.country_id') }}" />
			<x-form-input id="carlength" name="carlength" label="Länge" required />
			<x-form-input id="email" type="email" name="email" label="Email" />

			<x-form-input class="calc" name="from" type="date" label="Von" required />
			<x-form-input class="calc" name="until" type="date" label="Bis" required />
			<div class="mt-3">
				<x-form-checkbox class="calc" name="electric" label="Stromanschluß" />
			</div>
			<x-form-input class="calc" name="persons" label="Anzahl Personen" required />
			<x-form-input name="price" label="Preis" required />
			<div class="mt-2">
				<x-form-submit class="btn btn-save" icon="fas fa-save">Speichern</x-form-submit>
			</div>
        </x-form>
    </div>
@endsection

@push('inline-scripts')
    <script>
		const calcUrl = "{{ route("admin.caravan.price.calculate") }}",
				caravanOptions = {!! $caravanOptions !!};

		$(document).ready(() => {
			CaravanPrice.calculate(calcUrl, caravanOptions);
		})
    </script>
@endpush
