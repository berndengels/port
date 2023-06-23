@extends('layouts.main')

@section('main')
	<div>
		<div class="index-header mt-3 p-0">
			<div class="ms-0">
				<x-btn-create route="{{ route('admin.caravans.create') }}"/>
			</div>
			<div></div>
		</div>
		<x-form class="inline-form my-2" method="get" id="frmFilter" name="frmFilter"
				action="{{ route('admin.caravans.index') }}">
			@csrf
			<x-filter name="caravan" :options="$caravanOptions" :val="$id" inline/>
			<x-btn-reset/>
		</x-form>
		{{ $data->links() }}
		<x-table :items="$data"
				 :fields="['Kennzeichen','Länge','Email:md']"
				 :sortable="['carnumber'=>'Kennzeichen']"
				 hasActions isSmall>
			@foreach($data as $item)
				<tr>
					@bindData($item)
					<x-td field="carnumber" class="car"/>
					<x-td field="carlength"/>
					<x-td field="email:md"/>
					<x-action routePrefix="admin.caravans" edit delete/>
					@endBindData
				</tr>
			@endforeach
		</x-table>
		{{ $data->links() }}
	</div>
	<x-tooltip id="tooltip"/>
@endsection

@push('inline-scripts')
	<script>
		$(document).ready(() => {
			document.frmFilter.caravan.onchange = () => document.frmFilter.submit();
			$(".reset").click(e => {
				e.preventDefault();
				document.frmFilter.caravan.value = '';
				document.frmFilter.submit();
			});
			const routePrefix = "{{ route('admin.car.info') }}";
			Car.info(routePrefix, '.car', '#tooltip')
		});
	</script>
@endpush
