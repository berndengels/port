@extends('layouts.main')

@section('main')
	<div>
		<div class="index-header mt-3">
			<div>
				<x-btn-create route="{{ route('admin.apartments.create') }}"/>
			</div>
			<div></div>
		</div>
		@if($data && $data->count())
			{{ $data->links() }}
			<x-table :items="$data" :fields="['Name','Modell','Farbe']" hasActions isSmall>
				@foreach($data as $item)
					<tr>
						@bindData($item)
						<x-td field="name" link="{{ route('admin.apartments.show', $item) }}"/>
						<x-td field="model.name"/>
						<x-td field="calendar_color" color icon="fas fa-palette"/>
						<x-action routePrefix="admin.apartments" edit delete/>
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
