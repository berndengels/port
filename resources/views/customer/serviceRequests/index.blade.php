@extends('layouts.main')

@section('main')
	<div>
		<div class="index-header mt-4 p-0">
			<div class="float-start">
				<x-btn-create :route="route('customer.serviceRequests.create')"/>
			</div>
			<div class="float-end"></div>
		</div>
		@if($data->count() > 0)
			{{ $data->links() }}
			<x-table :items="$data" :fields="['Boot','Arbeit','Bis','Erledigt','Am','Erstellt','Bezahlt']" hasActions
					 isSmall>
				@foreach($data as $item)
					<tr>
						@bindData($item)
						<x-td field="boat.name"/>
						<x-td field="description:md" :link="route('customer.serviceRequests.show', $item)"/>
						<x-td field="done_until"/>
						<x-td field="done"/>
						<x-td field="done_at"/>
						<x-td field="created_at"/>
						<x-td field="is_paid"/>
						<x-action routePrefix="customer.serviceRequests" edit delete/>
						@endBindData
					</tr>
				@endforeach
			</x-table>
			{{ $data->links() }}
		@else
			<h3 class="m-5 fs-2 blue">Keine Daten vorhanden</h3>
		@endif
	</div>
@endsection
