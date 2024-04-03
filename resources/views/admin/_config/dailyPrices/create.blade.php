@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.configDailyPrices.index') }}"/>
		<x-form method="post" :action="route('admin.configDailyPrices.store')" class="w-half mt-3">
			<x-form-select id="model" name="model" label="Model" placeholder="Welche Model" :options="$optionsModel"
						   required/>
			<x-form-select id="saison_date_id" name="saison_date_id" label="Saison" placeholder="Welche Saison?"
						   :options="$optionsSaisonDates" required/>
			<x-form-select id="price_type_id" name="price_type_id" label="Preis Typ" placeholder="Welche Preis Typ?"
						   :options="$optionsPriceTypes" required/>
			<x-form-input type="number" step="0.1" min="0" id="from_unit" name="from_unit" label="Von"
						  placeholder="von (Einheit gemäß Preis-Type)"/>
			<x-form-input type="number" step="0.1" min="0" id="until_unit" name="until_unit" label="Bis"
						  placeholder="bis (Einheit gemäß Preis-Type)"/>
			<x-form-input type="number" step="0.01" min="0" id="price" name="price" label="Preis"
						  placeholder="Preis per Einheit oder absolut" required/>
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection

