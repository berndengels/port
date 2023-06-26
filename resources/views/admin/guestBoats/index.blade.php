@extends('layouts.main')

@section('main')
	<div>
		<div class="index-header mt-3 p-0">
			<div class="float-start">
				<x-btn-create route="{{ route('admin.guestBoats.create') }}"/>
			</div>
			<div></div>
		</div>
		<x-form class="inline-form my-2" method="get" id="frmFilter" name="frmFilter"
				action="{{ route('admin.guestBoats.index') }}">
			<x-filter name="guestBoat" :options="$guestBoatOptions" :val="$guestBoat" inline/>
			<x-btn-reset/>
		</x-form>
		{{ $data->links() }}
		<x-table :items="$data"
				 :fields="['Bootsname','Länge','Heimathafen:md','Email']"
				 :sortable="['name'=>'Bootsname']"
				 hasActions isSmall>
			@foreach($data as $item)
				<tr>
					@bindData($item)
					<x-td field="name"/>
					<x-td field="length"/>
					<x-td field="home_port:md"/>
					<x-td field="email"/>
					<x-action routePrefix="admin.guestBoats" edit delete/>
					@endBindData
				</tr>
			@endforeach
		</x-table>
		{{ $data->links() }}
	</div>
@endsection

@push('inline-scripts')
	<script>
		$(".reset").click(e => {
			e.preventDefault();
//			document.frmFilter.guestBoat.value = '';
			document.frmFilter.reset();
		});
	</script>
@endpush
