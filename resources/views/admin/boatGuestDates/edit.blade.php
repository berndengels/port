@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.boatGuestDates.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form name="frm" method="post" :action="route('admin.boatGuestDates.update', $boatGuestDate)" class="w-full lg:w-1/2">
            @method('put')
            @bind($boatGuestDate->boat)
            <x-form-input name="name" label="Boots Name" placeholder="Boots Name" required autocomplete="off" />
            <ul class="hidden w-full autocomplete"></ul>
            <x-form-input class="calc" name="length" type="number" step="1" label="Boots Länge" placeholder="Boots Länge" required />
            <x-form-input name="home_port" label="Heimathafen" placeholder="Heimathafen" />
            @endbind

            @bind($boatGuestDate)
            <x-form-input name="from" class="calc" type="date" label="Von" required :bind="false" :default="$boatGuestDate->validFrom" />
            <x-form-input name="until" class="calc" type="date" label="Bis" required :bind="false" :default="$boatGuestDate->validUntil" />
            <x-form-input class="calc" name="day_price" label="eigener Preis" placeholder="eigener Preis" />
            <x-form-input name="price" label="Gesamt-Preis" required />
            <x-form-input type="hidden" name="prices" required />
            @endbind
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
			    options = {!! $boatGuestsOptionsAutocomplete !!},
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
