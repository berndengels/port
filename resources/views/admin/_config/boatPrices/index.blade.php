@extends('layouts.main')

@section('main')
	<div>
		<div class="index-header mt-3 p-0">
			<div class="float-start">
				<x-btn-create route="{{ route('admin.config.boatPrices.create') }}"/>
			</div>
			<div class="float-end"></div>
		</div>
		{{ $data->links() }}
		<x-table :items="$data" :fields="['Name','Saison','Preis-Typ','Preis-Faktor']" hasActions isSmall>
			@foreach($data as $item)
				<tr>
					@bindData($item)
					<x-td field="name"/>
					<x-td field="saison.name"/>
					<x-td field="priceType.name"/>
					<x-td field="price_factor"/>
					<x-action routePrefix="admin.config.boatPrices" edit delete/>
					@endBindData
				</tr>
			@endforeach
		</x-table>
		{{ $data->links() }}
	</div>
@endsection
