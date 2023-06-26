@extends('layouts.main')

@section('main')
	<div>
		<div class="index-header mt-3 p-0">
			<div class="float-start">
				<x-btn-create route="{{ route('admin.apartmentRentals.create', ['modus' => $saison ?? null]) }}"/>
			</div>
			@if($data && $data->count() > 0 && $year || $month)
				<div class="float-end">
					<x-frm-excel
							:action="route('admin.apartmentRentals.sendExcel')"
							routeDownload="admin.houseboat.price.excel"
							:year="$year"
							:month="$month ?? ''"
					/>
				</div>
			@endif
		</div>

		<x-form class="inline-form ml-5" method="get" id="frmFilter" name="frmFilter"
				action="{{ route('admin.apartmentRentals.index') }}"
		>
			<x-filter name="houseboat" :options="$houseboatOptions" :val="$houseboat" inline/>
			<x-filter name="year" :options="$yearOptions" :val="$year" inline/>
			@if($year)
				<x-filter name="month" :options="$monthOptions" :val="$month" inline/>
			@endif
			<button class="btn btn-secondary reset btn-sm inline ms-2">Reset</button>
			<button role="link" id="toggleCalendar" class="btn btn-secondary reset btn-sm inline ms-2">Kalender</button>
		</x-form>

		@if($data && $data->count() > 0)

			<div id="calendarWrapper" class="position-relative bg-light">
				<div id="calendar" class="col-sm-12 col-md-8 col-lg-6"></div>
			</div>

			{{ $data->appends($queryString)->links() }}
			<x-table :items="$data" :fields="['Hausboot','Von','Bis','Gast:md','Fon','Preis:md','Bezahlt']" hasActions>
				@foreach($data as $item)
					<tr>
						@bindData($item)
						<x-td field="rentable.name" link="{{ route('admin.apartmentRentals.show', $item) }}"/>
						<x-td field="from"/>
						<x-td field="until"/>
						<x-td field="customer.name:md" link="mailto:{{ $item->customer->email }}" target="_blank"
							  icon="fas fa-at"/>
						<x-td field="customer.fon" link="tel:{{ $item->customer->fonLink }}" target="_blank"
							  icon="fas fa-phone"/>
						<x-td field="price:md"/>
						<x-td field="is_paid"/>
						<x-action routePrefix="admin.apartmentRentals" edit delete/>
						@endBindData
					</tr>
				@endforeach
			</x-table>
			<div class="mt-3 w-100 red"><strong>Summe Preis: {{ $priceTotal }} €</strong></div>
			{{ $data->appends($queryString)->links() }}
		@else
			<h3>Keine Daten vorhanden</h3>
		@endif
	</div>
@endsection

@push('inline-scripts')
	<script>
		$(document).ready(() => {
			const elCalendar = document.getElementById('calendar'),
				dates = {!! $calendarDates !!},
				initialDate = "{{ $initialDate }}";

			MyCalendar.houseboats(elCalendar, dates, {initialDate: initialDate});

			$("#toggleCalendar").click((e) => {
				e.preventDefault();
				$("#calendarWrapper").toggle();
			});

			Edit.toggle("/admin/apartmentRentals/toggle", "is_paid");
			const frm = document.frmFilter,
				filter = (e) => {
					let el = e.target;
					if ('' === el.value && ['year', 'month'].indexOf(el.name) === -1) {
						return;
					}
					switch (el.name) {
						case 'houseboat':
							frm.year.value = '';
							if (frm.month) {
								frm.month.value = '';
							}
							break;
						case 'year':
							if (frm.year.value === '' && frm.month) {
								frm.month.value = '';
							}
							frm.houseboat.value = '';
							break;
						case 'month':
							frm.houseboat.value = '';
							break
					}
					frm.submit()
				},
				reset = (e) => {
					e.preventDefault();
					document.frmFilter.houseboat.value = '';
					if (document.frmFilter.year) document.frmFilter.year.value = '';
					if (document.frmFilter.month) {
						document.frmFilter.month.value = '';
						$(document.frmFilter.month).hide();
					}
					document.frmFilter.submit()
				};

			frm.querySelectorAll('.filter').forEach(item => {
				item.onchange = filter
			});
			frm.querySelector('.reset').onclick = reset
		});
	</script>
@endpush
