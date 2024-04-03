@extends('layouts.main')

@section('main')
	<div>
		<div class="index-header mt-3 p-0">
			<div class="ms-0">
				<x-btn-create route="{{ route('admin.configSaisonRentDates.create') }}"/>
			</div>
			<div></div>
		</div>
		{{ $data->links() }}
		<x-table :items="$data" :fields="['Saison','Name','Feiertage','Von','Bis']" hasActions isSmall>
			@foreach($data as $item)
				<tr>
					@bindData($item)
					<x-td field="saison.name"/>
					<x-td field="name"/>
					<x-td field="holiday"/>
					<x-td field="from"/>
					<x-td field="until"/>
					<x-action routePrefix="admin.configSaisonRentDates" edit delete/>
					@endBindData
				</tr>
			@endforeach
		</x-table>
		{{ $data->links() }}
	</div>
@endsection
