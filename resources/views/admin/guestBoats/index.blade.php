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
			<x-form-select name="guestBoat" id="guestBoat" :options="$guestBoatOptions" :default="$guestBoat" floating />
			<x-btn-reset />
		</x-form>
		{{ $data->links() }}
		<x-table :items="$data"
				 :fields="['Bootsname','Länge','Heimathafen:md','Email']"
				 :sortable="['name'=>'Bootsname']"
				 hasActions isSmall>
			@foreach($data as $item)
				<tr>
					@bindData($item)
					<x-td field="name" link="{{ route('admin.guestBoats.show', $item) }}"/>
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
		$(document).ready(() => {
			$(".reset").click(() => {
				location.href = "{{ route('admin.guestBoats.index') }}";
			});
			$('#guestBoat').change(() => {
				document.frmFilter.submit();
			});
		});
	</script>
@endpush
