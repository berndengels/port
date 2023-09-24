@extends('layouts.main')

@section('main')
	<div>
		<div class="index-header mt-3 p-0">
			<div class="float-start">
				<x-btn-create route="{{ route('admin.caravanDates.create') }}"/>
			</div>
			@if($data->count() > 0 && $from || $until)
				<div class="float-end">
					<x-frm-excel
							:action="route('admin.caravanDates.sendExcel')"
							routeDownload="{{ route('admin.caravan.price.excel', compact('from','until')) }}"
							:from="$from"
							:until="$until"
					/>
				</div>
			@endif
		</div>

		@if($data->count() > 0)
			<x-form class="inline-form ms-0 my-3" method="get" id="frmFilter" name="frmFilter"
					action="{{ route('admin.caravanDates.index') }}"
			>
				<x-form-select name="caravan" :options="$caravanOptions" floating />
				@if($dublicateOptions)
					<x-filter name="dublicate" :options="$dublicateOptions" :val="$dublicate" floating />
				@endif
				<x-form-input :default="$from ? $from->format('Y-m-d') : null" name="from" type="date"
							  :min="$firstDate->format('Y-m-d')" :max="$lastDate->format('Y-m-d')" label="von"
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
								 :fields="['Kennzeichen','Von','Bis','Tage:md','Preis:md','bezahlt']"
								 :sortable="['caravan.carnumber'=>'Kennzeichen','from'=>'Von','until'=>'Bis']"
								 hasActions isSmall>
							@sortablelink('caravan.carnumber')

							@foreach($data as $item)
								<tr>
									@bindData($item)
									<x-td field="caravan.carnumber" link="{{ route('admin.caravanDates.show', $item) }}"
										  icon="fas fa-caravan"/>
									<x-td field="from"/>
									<x-td field="until"/>
									<x-td field="days:md"/>
									<x-td field="price:md"/>
									<x-td field="is_paid"/>
									<x-action routePrefix="admin.caravanDates" edit delete/>
									@endBindData
								</tr>
							@endforeach
						</x-table>
					</div>
					<div class="col-sm-11 col-lg-2">
						<x-sum-price :brutto="$priceTotal"/>
					</div>
				</div>
			</div>
			{{ $data->appends($queryString)->links() }}
		@else
			<h5>Keine Daten vorhanden</h5>
		@endif
	</div>
	<x-tooltip id="tooltip"/>
@endsection

@push('inline-scripts')
	<script>
		$(document).ready(() => {
			Edit.toggle("/admin/caravanDates/toggle", "is_paid");
			const frm = document.frmFilter,
				filter = (e) => {
					let el = e.target;
					if ('' === el.value || !el.value) {
						return;
					}
					switch (el.name) {
						case 'caravan':
							if (frm.dublicate) {
								frm.dublicate.value = '';
							}
							frm.from.value = '';
							frm.until.value = '';
							break;
						case 'dublicate':
							frm.caravan.value = '';
							frm.from.value = '';
							frm.until.value = '';
							break;
						case 'from':
							frm.caravan.value = '';
							if (frm.dublicate) {
								frm.dublicate.value = '';
							}
							break;
						case 'until':
							frm.caravan.value = '';
							if (frm.dublicate) {
								frm.dublicate.value = '';
							}
							break
					}
					frm.submit()
				},
				reset = (e) => {
					e.preventDefault();
					document.frmFilter.caravan.value = '';
					if (document.frmFilter.dublicate) {
						document.frmFilter.dublicate.value = '';
					}
					document.frmFilter.from.value = '';
					document.frmFilter.until.value = '';
					document.frmFilter.submit();
				};

			frm.querySelectorAll('.filter').forEach(item => {
				item.onchange = filter
			});
			frm.querySelector('.reset').onclick = reset;

			const routePrefix = "{{ route('admin.car.info') }}";
			Car.info(routePrefix, '.carnumber', '#tooltip')
		});
	</script>
@endpush
