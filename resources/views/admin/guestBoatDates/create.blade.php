@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.guestBoatDates.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form name="frm" method="post" :action="route('admin.guestBoatDates.store')" class="w-full lg:w-1/2">
            <x-form-input id="name" name="name" label="Boots Name" placeholder="Boots Name" required autocomplete="off" />
            <ul class="hidden w-full autocomplete"></ul>
            <x-form-input class="calc" id="length" name="length" type="number" step="1" min="1" label="Boots Länge" placeholder="Boots Länge" required />
            <x-form-input id="home_port" name="home_port" label="Heimathafen" placeholder="Heimathafen" />

            <x-form-input class="calc" id="from" name="from" type="date" label="Von" required />
            <x-form-input class="calc" id="until" name="until" type="date" label="Bis" required />
            <div class="mt-3">
                <x-form-checkbox class="calc" id="electric" name="electric" label="Stromanschluß" />
            </div>
            <x-form-input class="calc" type="number" step="1" min="1" id="persons" name="persons" label="Anzahl Personen" required />
            <x-form-input class="calc" id="day_price" name="day_price" label="eigener Preis" placeholder="eigener Preis" />
            <x-form-input type="number" id="price" name="price" min="0" label="Gesamt-Preis" required />
            <x-form-input type="hidden" id="prices" name="prices" required />
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

@push('inline-scripts')
    <script>
	    const calcUrl = "{{ route("admin.guestBoatDates.price.calculate") }}";
	    $(document).ready(() => {
		    const frm = document.frm,
			    options = {!! $guestBoatOptionsAutocomplete !!},
			    bindings = {
				    name: frm.name,
				    length: frm.length,
				    home_port: frm.home_port,
			    };
		    MyForm.autocomplete(".autocomplete", frm.name, options, 'name', bindings);
		    Prices.guestBoatDates.calculate(document.frm, calcUrl);
	    })
    </script>
@endpush
