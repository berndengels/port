@extends('layouts.main')

@section('main')
	<div class="mt-3">
		{{ $data->links() }}
		<x-table class="w-50" :items="$data" :fields="['Key:md','Name','Aktiv']" isSmall>
			@foreach($data as $item)
				<tr>
					@bindData($item)
					<x-td field="key:md"/>
					<x-td field="name" translate/>
					<x-td field="enabled"/>
					<!--x-action routePrefix="admin.holidays" edit delete /-->
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
			Edit.toggle("/admin/config/holidays/toggle", "enabled");
		});
	</script>
@endpush
