@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3 p-0">
            <div class="float-start">
                <x-btn-create route="{{ route('admin.'.$routeName.'.create') }}" />
            </div>
            @if($data && $data->count() > 0 && $from || $until)
                <div class="float-end">
                    <x-frm-excel
                        action="{{ route('admin.'.$routeName.'.sendExcel', $rentable) }}"
                        routeDownload="{{ route('admin.rentals.price.excel', compact('rentable','from','until')) }}"
                        :from="$from"
                        :until="$until"
                    />
                </div>
            @endif
        </div>

		@if($data && $data->count() > 0)
        <x-form class="inline-form ml-5" method="get" id="frmFilter" name="frmFilter"
                action="{{ route('admin.'.$routeName.'.index') }}"
        >
            <x-filter name="filter" :options="$relationOptions" :val="$filter" inline />
			<x-form-input :default="$from ? $from->format('Y-m-d') : null" name="from" type="date" :min="$firstDate->format('Y-m-d')" :max="$lastDate->format('Y-m-d')" inline label="von" placeholder="Von" />
			<x-form-input :default="$until ? $until->format('Y-m-d') : null" name="until" type="date" :min="$firstDate->format('Y-m-d')" :max="$lastDate->format('Y-m-d')" inline label="bis" placeholder="Bis" />
            <button class="btn btn-secondary reset btn-sm inline ms-2">Reset</button>
            <button role="link" id="toggleCalendar" class="btn btn-secondary reset btn-sm inline ms-2">Kalender</button>
        </x-form>

        <div id="calendarWrapper" class="bg-light">
			<div id="calendar" class="pe-3"></div>
        </div>
        {{ $data->appends($queryString)->links() }}
		<div class="container-fluid ps-0">
			<div class="row mt-3">
				<div class="col-sm-11 col-lg-9">
					<x-table :items="$data"
							 :fields="['Objekt','Art','Von','Bis','Gast:md','Fon','Preis:md','Bezahlt']"
							 :sortable="['from'=>'Von','is_paid'=>'Bezahlt']"
							 hasActions>
						@foreach($data as $item)
							<tr>
								@bindData($item)
								<x-td field="rentable.name" link="{{ route('admin.'.$routeName.'.show', $item) }}" />
								<x-td field="rentable_type" translate />
								<x-td field="from" />
								<x-td field="until" />
								<x-td field="customer.name:md" link="mailto:{{ $item->customer->email }}" target="_blank" icon="fas fa-at" />
								<x-td field="customer.fon" link="tel:{{ $item->customer->fonLink }}" target="_blank" icon="fas fa-phone" />
								<x-td field="price:md" />
								<x-td field="is_paid" />
								<x-action routePrefix="admin.{{ $routeName }}" edit delete />
								@endBindData
							</tr>
						@endforeach
					</x-table>
				</div>
				<div class="col-sm-11 col-lg-2 mt-3">
					<x-sum-price :brutto="$priceTotal" class="rentals" />
				</div>
			</div>
		</div>
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
		        initialDate = "{{ $initialDate }}",
				routeName = "{{ $routeName }}";

			MyCalendar.rentals(elCalendar, dates, {initialDate: initialDate});

	        $("#toggleCalendar").click((e) => {
				e.preventDefault();
				$("#calendarWrapper").toggle();
	        });

	        Edit.toggle("/admin/" + routeName + "/toggle","is_paid");
	        const frm = document.frmFilter,
		        filter = (e) => {
			        let el = e.target;
			        if ('' === el.value) {
				        return;
			        }
			        switch (el.name) {
				        case 'filter':
					        frm.from.value = '';
							frm.until.value = '';
					        break;
				        case 'from':
				        case 'until':
					        frm.filter.value = '';
					        break
			        }
			        frm.submit()
		        },
		        reset = (e) => {
			        e.preventDefault();
			        document.frmFilter.filter.value = '';
					document.frmFilter.from.value = '';
					document.frmFilter.until.value = '';
			        document.frmFilter.submit()
		        };

	        frm.querySelectorAll('.filter').forEach(item => {
		        item.onchange = filter
	        });
	        frm.querySelector('.reset').onclick = reset
        });
    </script>
@endpush
