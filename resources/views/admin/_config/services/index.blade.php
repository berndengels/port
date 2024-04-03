@extends('layouts.main')

@section('main')
	<div>
		<div class="index-header mt-3 p-0">
			<div class="ms-0">
				<x-btn-create route="{{ route('admin.configServices.create') }}"/>
			</div>
			<div></div>
		</div>
		{{ $data->links() }}
		<x-table :items="$data" :fields="['Name','Key']" hasActions isSmall>
			@foreach($data as $item)
				<tr>
					@bindData($item)
					<x-td field="name"/>
					<x-td field="key"/>
					<x-action routePrefix="admin.configServices" edit delete/>
					@endBindData
				</tr>
			@endforeach
		</x-table>
		{{ $data->links() }}
	</div>
@endsection

@push('inline-scripts')
	<script>
	</script>
@endpush
