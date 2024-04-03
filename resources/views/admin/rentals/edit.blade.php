@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.'.$routeName.'.index') }}"/>
		<div class="flex-row">
			<div class="flex-column">
				<x-form name="frm" action="{{ route('admin.'.$routeName.'.update', $rental) }}" class="w-half mt-3">
					@method('put')
					<div class="my-1">
						<span class="fs-5 blue">Objekt: {{ __(class_basename($rental->rentable)) }} {{ $rental->rentable->name }}</span>
					</div>
					<div class="my-1">
						<span class="fs-5 blue">Gast: {{ $rental->customer->name }}, {{ $rental->customer->email }}</span>
					</div>
					<input type="hidden" class="calc" id="rentable_id" name="rentable_id"
						   value="{{ $rental->rentable_id }}"/>
					<input type="hidden" class="calc" id="rentable_type" name="rentable_type"
						   value="{{ $rental->rentable_type }}"/>
					@bind($rental)
					<x-form-checkbox id="is_paid" name="is_paid" label="Ist Bezahlt" class="mb-0 pb-0"/>
					<x-form-select id="customer_id" name="customer_id" label="Gast"
								   :options="$customerOptions" required/>
					<x-form-input class="calc" id="from" name="from" type="date" label="Von" required/>
					<x-form-input class="calc" id="until" name="until" type="date" label="Bis" required/>

					@if($priceComponents->count() > 0)
						@foreach($priceComponents as $pc)
							@php $has = $pc->{'has'.Str::ucfirst($pc->key)}; @endphp
							<div class="mt-3">
								<x-form-checkbox class="calc" id="{{ $pc->key }}" name="{{ $pc->key }}"
												 label="{{ $pc->name }}" default="{{ $has }}"/>
								@if('kilowatt' === $pc->key)
									<x-form-input class="calc" id="kilowatt_value" name="kilowatt_value" type="number"
												  min="0" step="0.1" value="0" label="Stromverbrauch in Kw"/>
								@elseif('personen' === $pc->key)
									<x-form-input class="calc" id="personen" name="personen" type="number"
												  min="1" max="10" step="1" value="0" label="Anzahl Personen"/>
								@endif
							</div>
						@endforeach
					@endif
					<x-form-input id="price" name="price" type="number" min="0" label="Gesamt-Preis"/>
					<x-form-input type="hidden" name="prices"/>
					@endbind
					<div class="mt-2">
						<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
					</div>
				</x-form>
			</div>
			<div class="flex-column">
				<div class="mt-2" id="calendar"></div>
			</div>
		</div>
	</div>
@endsection

@push('inline-scripts')
	<script>
		$(document).ready(() => {
			const elCalendar = document.getElementById('calendar'),
				dates = {!! $calendarDates !!},
				options = {
					initialDate: "{!! $initialDate->format('Y-m-d') !!}",
				},
				calendar = MyCalendar.rentals(elCalendar, dates, options);

			let $from = $('#from'),
				$until = $('#until'),
				event = null;

			if ($from.is(':visible')) {
				$from.change(e => {
					let val = $(e.target).val();
					val = moment(val).add(12, 'hours').format('YYYY-MM-DD HH:00:00');
					if (!event) {
						event = calendar.addEvent({
							allDay: false,
							title: "Neueintrag",
							color: '#0a0',
							start: val,
						});
					}
					event.setStart(val)
				})
			}
			if ($until.is(':visible')) {
				$until.change(e => {
					let val = $(e.target).val();
					val = moment(val).add(12, 'hours').format('YYYY-MM-DD HH:00:00');
					if (event) {
						event.setEnd(val)
					}
				})
			}
			const calcUrl = "{{ route('admin.rentals.price.calculate') }}";
			Prices.calculate(document.frm, calcUrl);
		});
	</script>
@endpush
