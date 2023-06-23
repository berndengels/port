@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.rentals.index', ['saison' => $modus ?? null]) }}"/>
		<div class="flex-row">
			<div class="flex-column">
				<x-form name="frm" method="post" action="{{ route('admin.rentals.store') }}" class="w-half mt-3">
					<x-form-checkbox id="is_paid" name="is_paid" label="Ist Bezahlt" class="mb-0 pb-0"/>
					<x-form-select class="calc" id="houseboat_id" name="houseboat_id" label="Hausboot"
								   :options="$houseboatOptions" required/>
					<x-form-select id="customer_id" name="customer_id" label="Gast"
								   :options="$customerOptions" required/>
					<x-form-input class="calc" id="from" name="from" type="date" label="Von" required/>
					<x-form-input class="calc" id="until" name="until" type="date" label="Bis" required/>
					<x-form-input id="price" name="price" type="number" min="0" label="Gesamt-Preis"/>
					<x-form-input type="hidden" name="prices"/>
					<div class="mt-2">
						<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">
							Speichern
						</x-form-submit>
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
		const elCalendar = document.getElementById('calendar'),
			dates = {!! $calendarDates !!},
			calendar = MyCalendar.houseboats(elCalendar, dates),
			events = calendar.getOption('events'),
			id = (new Date()).getTime()
		;

		let $from = $('#from'),
			$until = $('#until'),
			event = null;
		console.info(event);

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
		Prices.houseboatRentals.calculate(document.frm, calcUrl);
	</script>
@endpush
