@extends('layouts.main')

@section('main')
	<div>
		<div class="index-header mt-3 p-0">
			<div class="float-start">
				<x-btn-create route="{{ route('admin.guestBoatDates.create') }}"/>
			</div>
			@if($data->count() > 0 && $from || $until)
				<div class="float-end">
					<x-frm-excel
							:action="route('admin.guestBoatDates.sendExcel')"
							routeDownload="{{ route('admin.guestBoat.price.excel', compact('from','until')) }}"
							:from="$from"
							:until="$until"
					/>
				</div>
			@endif
		</div>
		<x-form class="inline-form ms-0 my-3" method="get" id="frmFilter" name="frmFilter"
				action="{{ route('admin.guestBoatDates.index') }}">
			<x-form-select name="guestBoat" id="guestBoat" :options="$guestBoatOptions" :default="$guestBoat" floating />

			<x-form-input :default="$from ? $from->format('Y-m-d') : null" name="from" type="date"
						  :min="$firstDate->format('Y-m-d')" :max="$lastDate->format('Y-m-d')" inline label="von"
						  floating />
			<x-form-input :default="$until ? $until->format('Y-m-d') : null" name="until" type="date"
						  :min="$firstDate->format('Y-m-d')" :max="$lastDate->format('Y-m-d')" inline label="bis"
						  floating />
			<x-btn-reset/>
		</x-form>
		{{ $data->appends($queryString)->links() }}
		<div class="container-fluid ps-0">
			<div class="row mt-3">
				<div class="col-sm-11 col-lg-9">
					<x-table :items="$data"
							 :fields="['Bootsname','Liegeplatz','Von','Bis','Tage:md','Preis:md','bezahlt']"
							 :sortable="['boat.name'=>'Bootsname','from'=>'Von','until'=>'Bis']"
							 hasActions isSmall>
						@foreach($data as $item)
							<tr>
								@bindData($item)
								<x-td field="boat.name" :link="route('admin.guestBoatDates.show', $item)"/>
								<x-td field="berth.dock.name" :append="['berth.number']"/>
								<x-td field="from"/>
								<x-td field="until"/>
								<x-td field="days:md"/>
								<x-td field="price:md"/>
								<x-td field="is_paid"/>
								<x-action routePrefix="admin.guestBoatDates" edit delete/>
								@endBindData
							</tr>
						@endforeach
					</x-table>
				</div>
				<div class="col-sm-11 col-lg-2 mt-3">
					<x-sum-price :brutto="$priceTotal"/>
				</div>
			</div>
		</div>
		{{ $data->appends($queryString)->links() }}
	</div>
@endsection

@push('inline-scripts')
	<script>
		Edit.toggle("/admin/guestBoatDates/toggle", "is_paid");
		$('#guestBoat').change(() => {
			document.frmFilter.submit();
		});
		$(".reset").click(() => {
			location.href = "{{ route('admin.guestBoats.index') }}";
		});
	</script>
@endpush
