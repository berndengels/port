@extends('layouts.main')

@section('main')
	<div>
		{{ $data->links() }}
		<x-table :items="$data" :fields="['Boot','Saison','Von','Bis','Preis in €']" hasActions isSmall>
			@foreach($data as $item)
				<tr>
					@bindData($item)
					<x-td field="boat.name"/>
					<x-td field="modus" translate/>
					<x-td field="from"/>
					<x-td field="until"/>
					<x-td field="price"/>
					<x-action routePrefix="customer.boatDates" show/>
					@endBindData
				</tr>
			@endforeach
		</x-table>
		{{ $data->links() }}
	</div>
@endsection
