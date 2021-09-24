@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.caravanDates.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form name="frm" action="{{ route('admin.caravanDates.update', ['caravanDate' => $caravanDate->id]) }}" class="w-full lg:w-1/2">
            @method('put')
            @bind($caravanDate->caravan)
            <x-form-input name="carnumber" label="Autokennzeichen" required />
            <x-form-select name="country_id" label="Herkunftsland" :options="$countries" />
            <x-form-input name="carlength" label="Länge" required />
            <x-form-input type="email" name="email" label="Email" />
            @endbind

            @bind($caravanDate)
            <x-form-input name="from" class="calc" type="date" label="Von" required :bind="false" :default="$caravanDate->validFrom" />
            <x-form-input name="until" class="calc" type="date" label="Bis" required :bind="false" :default="$caravanDate->validUntil" />
            <div class="mt-3">
                <x-form-checkbox class="calc" name="electric" label="Stromanschluß" />
            </div>
            <x-form-input class="calc" name="persons" label="Anzahl Personen" required />
            <x-form-input name="price" label="Preis" required />
            @endbind

            <x-form-submit class="rounded">Speichern</x-form-submit>
        </x-form>
    </div>
@endsection

@push('inline-scripts')
    <script>
		const calcUrl		= "{{ route("admin.caravan.price.calculate") }}",
			caravanOptions 	= {!! $caravanOptions !!},
			$elSelect       = $('#caravans'),
			$elCarnumber    = $('#carnumber'),
			$elCarlength    = $('#carlength'),
			$elCountryId    = $('#country_id'),
			$elEmail        = $('#email'),
			caravans        = [],
			$elObserve      = $('.calc'),
			caravan = null;

		var filterd = [];

		$elCarnumber.keyup(e => {
			var $el=$(e.target),options=[],$li=$('<li>'),i=0,item;
			$elSelect.empty();

			if($el.val().length > 0) {
				for(item of caravanOptions) {
					if(item.carnumber.indexOf($el.val().toUpperCase()) === 0) {
						caravans[item.id] = item
						$elSelect.append($($li.clone().attr('data-id', item.id).text(item.carnumber)))
						i++
					}
				}
				if(i > 0) {
					$elSelect.removeClass('hidden');
				} else {
					$elSelect.addClass('hidden');
				}
			}
		});
		$elSelect.click(e => {
			let $el = $(e.target)
			let caravan = caravans[$el.data('id')]
			$elCarnumber.val(caravan.carnumber)
			$elCarlength.val(caravan.carlength)
			$elCountryId.val(caravan.country_id)
			$elEmail.val(caravan.email)
			$elSelect.addClass('hidden');
		});
		$elObserve.change(el => {
			var frm = document.frm;

			if("" !== frm.from.value && frm.until.value && frm.persons.value && frm.carlength.value) {
				let formData = new FormData();
				for(elem of frm.elements) {
					formData.append(elem.name, elem.value)
				}
				formData.set('electric', frm.electric.checked ? 1 : 0)
				axios.post(calcUrl, formData)
					.then(resp => {
						frm.price.value = resp.data.total
						frm.prices.value = JSON.stringify(resp.data.prices)
					})
					.catch(err => console.error(err))
				;
			}
		});
    </script>
@endpush


