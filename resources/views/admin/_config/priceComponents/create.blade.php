@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.configPriceComponents.index') }}"/>
		<x-form method="post" :action="route('admin.configPriceComponents.store')" class="w-half mt-3">
			<x-form-select id="entities" name="entities[]" label="Betrifft was" :options="$optionsEntityTypes"
						   size="4" class="flexy" many-relation multiple required
			/>
			<x-form-select id="config_service_id" name="config_service_id" label="Service Art"
						   :options="$optionsServices"/>
			<x-form-select id="price_type_id" name="price_type_id" label="Preis Typ" :options="$optionsPriceTypes"
						   required/>
			<x-form-select id="config_unit_range_type_id" name="config_unit_range_type_id" label="UnitRange Typ" :options="$optionsUnitRangeTypes"/>
			<x-form-input type="number" min="0" step="0.1" id="unit_from" name="unit_from"
						  label="Ab Einheit"
						  placeholder="Gilt ab entsprechnder Einheit"/>
			<x-form-input type="number" min="0" step="0.1" id="unit_until" name="unit_until"
						  label="Bis Einheit"
						  placeholder="Gilt bis entsprechnder Einheit"/>
			<x-form-input id="name" name="name" label="Name" placeholder="Name der Preis Komponente" required/>
			<x-form-input id="key" name="key" label="Key" required/>
			<x-form-input type="number" min="0" step="1" id="unit_inclusive" name="unit_inclusive"
						  label="Wieviel Einheiten sind inklusive"
						  placeholder="Wieviel Einheiten sind inklusive im Preis"/>
			<x-form-input type="number" min="0" step="0.01" id="unit_price" name="unit_price" label="Preis pro Einheit"
						  placeholder="Preis pro Eineit in €" required/>
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection

