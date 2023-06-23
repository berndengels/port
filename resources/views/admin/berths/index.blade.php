@extends('layouts.main')

@section('main')
	<div class="mb-5">
		<div id="frm">
			<div>
				<h5>Liegeplatz Gruppen Eingeschaften</h5>
				<x-form class="m-3">
					<x-form-select name="dock_id" label="Steg" :options="$dockOptions" required/>
					<x-form-input id="prefix" name="prefix" label="Prefix"/>
					<x-form-input id="start" name="start" type="number" step="1" min="1" label="Startnummer"/>
					<x-form-input id="end" name="end" type="number" step="1" min="1" label="Endnummer"/>
					<x-form-input id="width" name="width" type="number" step="0.1" min="1" label="Breite"/>
					<x-form-input id="length" name="length" type="number" step="0.1" min="1" label="Länge"/>
					<x-form-input id="dailyPrice" name="dailyPrice" type="number" step="1" min="1" label="Tagespreis"/>
				</x-form>
			</div>
		</div>
		<div id="mapBerths"></div>
		<button id="storeBerths" class="btn btn-save">Alle Daten Speichern</button>
	</div>
	<div>
		<div class="index-header mt-3">
			<div>
				<x-btn-create route="{{ route('admin.berths.create') }}"/>
			</div>
			<div></div>
		</div>
		{{ $data->links() }}
		<x-table :items="$data" :fields="['Nummer','Länge (m)','Breite (m)','Tagespreis (€)','Lat','lng']" hasActions
				 isSmall>
			@foreach($data as $item)
				<tr>
					@bindData($item)
					<x-td field="number"/>
					<x-td field="length"/>
					<x-td field="width"/>
					<x-td field="daily_price"/>
					<x-td field="lat"/>
					<x-td field="lng"/>
					<x-action routePrefix="admin.berths" edit delete/>
					@endBindData
				</tr>
			@endforeach
		</x-table>
		{{ $data->links() }}
	</div>
@endsection

@push('inline-scripts')
	<script>
		window.onload = () => {
			Edit.toggle("/admin/berths/toggle", "enabled");
			Geo.berthMap('mapBerths', '#storeBerths');
		}
	</script>
@endpush
