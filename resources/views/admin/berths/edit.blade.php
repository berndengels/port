@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.berths.index') }}"/>
		<x-form name="frm" method="post" :action="route('admin.berths.update', $berth)" class="w-half mt-3">
			@method('put')
			@bind($berth)
			<x-form-checkbox name="enabled" label="Aktiv"/>
			<x-form-select name="dock_id" label="Steg" :options="$dockOptions" required/>
			<x-form-input name="number" label="Nummer" placeholder="Liegeplatz-Nummer" required/>
			<x-form-input name="length" type="number" step="0.1" min="1" label="Länge" placeholder="Länge" required/>
			<x-form-input name="width" type="number" step="0.1" min="1" label="Breite" placeholder="Breite" required/>
			<x-form-input name="daily_price" type="number" step="1" min="1" label="Tagespreis"
						  placeholder="Tagespreis"/>
			<x-form-input name="lat" type="number" step="1" min="1" label="Latitude" placeholder="Latitude"/>
			<x-form-input name="lng" type="number" step="1" min="1" label="Longitude" placeholder="Longitude"/>
			@endbind
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection

@push('inline-scripts')
	<script>
	</script>
@endpush
