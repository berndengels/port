@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.guestBoatDates.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form name="frm" method="post" :action="route('admin.guestBoatDates.update', $guestBoatDate)" class="w-full lg:w-1/2 mt-5">
            @method('put')
            <x-form-checkbox id="is_paid" name="is_paid" label="Ist Bezahlt" :bind="$guestBoatDate" class="mb-0 pb-0" />
            @bind($guestBoatDate->boat)
            <x-form-input id="name" name="name" label="Boots Name" placeholder="Boots Name" required autocomplete="off" />
            <ul class="hidden w-full autocomplete"></ul>
            <x-form-input id="length" class="calc" name="length" type="number" step="1" min="1" label="Boots Länge" placeholder="Boots Länge" required />
            <x-form-input id="home_port" name="home_port" label="Heimathafen" placeholder="Heimathafen" />
            @endbind

            @bind($guestBoatDate)
            <x-form-input name="from" class="calc" type="date" label="Von" required :bind="false" default="{{ $guestBoatDate->validFrom }}" />
            <x-form-input name="until" class="calc" type="date" label="Bis" required :bind="false" default="{{ $guestBoatDate->validUntil }}" />
            <div class="mt-3">
                <x-form-checkbox class="calc" id="electric" name="electric" label="Stromanschluß" />
            </div>
            <x-form-input class="calc" type="number" step="1" min="1" id="persons" name="persons" label="Anzahl Personen" required />
            <!--x-form-input class="calc" name="special_price" label="Spezial Preis" /-->
            <x-form-input type="number" id="price" name="price" min="0" label="Gesamt-Preis" required />
            <x-form-input type="hidden" id="prices" name="prices" required />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

@push('inline-scripts')
    <script>
	    const calcUrl = "{{ route('admin.guestBoatDates.price.calculate') }}";
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
