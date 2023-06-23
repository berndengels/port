@extends('layouts.main')

@section('main')
	<div>
		<div class="index-header mt-3 p-0">
			<div>
				<x-btn-create route="{{ route('admin.apartmentModels.create') }}"/>
			</div>
			<div></div>
		</div>
		@if($data && $data->count())
			{{ $data->links() }}
			<x-table :items="$data"
					 :fields="['Name','Stockwerke:md','Fläche:md','max. Personen:md','Hauptsaison','Zwischensaison','Nebensaison']"
					 hasActions isSmall>
				@foreach($data as $item)
					<tr>
						@bindData($item)
						<x-td field="name" link="{{ route('admin.apartmentModels.show', $item) }}"/>
						<x-td field="floors:md"/>
						<x-td field="space:md"/>
						<x-td field="sleeping_places:md"/>
						<x-td field="peak_season_price:md" append="€"/>
						<x-td field="mid_season_price" append="€"/>
						<x-td field="low_season_price" append="€"/>
						<x-action routePrefix="admin.apartmentModels" edit delete/>
						@endBindData
					</tr>
				@endforeach
			</x-table>
			{{ $data->links() }}
		@else
			<h1 class="m-5">Keine Daten vorhanden</h1>
		@endif
	</div>
@endsection
