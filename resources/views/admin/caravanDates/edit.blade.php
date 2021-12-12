@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.caravanDates.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>

        <x-form name="frm" action="{{ route('admin.caravanDates.update', ['caravanDate' => $caravanDate->id]) }}" class="w-full lg:w-1/2">
            @method('put')
            @bind($caravanDate->caravan)
            <x-form-input name="carnumber" label="Autokennzeichen" required />
            <x-form-select name="country_id" label="Herkunftsland" :options="$countries" />
            <x-form-input name="carlength" type="number" label="Länge" required />
            <x-form-input type="email" name="email" label="Email" />
            @endbind

            @bind($caravanDate)
            <x-form-input name="prices" type="hidden" />
            <x-form-input name="from" class="calc" type="date" label="Von" required :bind="false" default="{{$caravanDate->validFrom}}" />
            <x-form-input name="until" class="calc" type="date" label="Bis" required :bind="false" default="{{$caravanDate->validUntil}}" />
            <div class="mt-3">
                <x-form-checkbox class="calc" name="electric" label="Stromanschluß" />
            </div>
            <x-form-input class="calc" name="persons" step="1" min="1" type="number" label="Anzahl Personen" required />
            <!--x-form-input class="calc" name="special_price" label="Spezial Preis" /-->
            <x-form-input name="price" type="number" min="0" label="Gesamt-Preis" required />
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
		const calcUrl = "{{ route("admin.caravanDates.price.calculate") }}",
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


