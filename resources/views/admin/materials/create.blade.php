@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.materials.index') }}"/>
		<x-form method="post" :action="route('admin.materials.store')" class="w-half mt-3">
			<x-form-input name="name" label="Name" required/>
			<x-form-select class="mt-1" name="material_category_id" label="Kategorie" :options="$categories" required/>

			<x-form-group class="row mt-2" label="Preis per Maßeinheit">
				<x-form-input class="col-2" type="number" step="0.01" name="price_per_unit" required/>
				€
				<x-form-select class="col-2 ms-2" name="price_type_id" :options="$priceTypes" required/>
			</x-form-group>

			<x-form-group class="row mt-2"
						  label="<strong>Material Ergiebigkeit</strong><br>pro Maßeinheit benötigte Menge an Material in einer bestimmten Maßeinheit">
				<x-form-select class="col-3" name="fertility_per" :options="$fertilityPers" label="pro"
							   help="pro Maßeinheit (Fläche, Länge, Volumen etc)"
				/>
				<x-form-input class="col-3 ms-2" type="number" step="0.001" name="fertility" label="schafft man"
							  help="benötigt man soundsoviel Material"
				/>
				<x-form-select class="col-3 ms-2" name="fertility_unit" :options="$fertilityUnits"
							   help="in folgender Maßeinheit"
				/>
			</x-form-group>
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
	<x-tooltip id="tooltip"/>
@endsection

@push('inline-scripts')
	<script>
		Tooltip.prepare('i.help')
	</script>
@endpush

