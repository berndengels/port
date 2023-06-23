@extends('layouts.main')

@section('main')
	<div>
		<div class="index-header mt-3 p-0">
			<div class="float-start">
				<x-btn-create route="{{ route('customer.boats.create') }}"/>
			</div>
			<div class="float-end"></div>
		</div>
		{{ $data->links() }}
		<x-table :items="$data" :fields="['Boot','Type']" hasActions isSmall>
			@foreach($data as $item)
				<tr>
					@bindData($item)
					<x-td field="name" :link="route('customer.boats.show', $item)"/>
					<x-td field="type" translate/>
					<x-action routePrefix="customer.boats" edit/>
					@endBindData
				</tr>
			@endforeach
		</x-table>
		{{ $data->links() }}
	</div>
@endsection
