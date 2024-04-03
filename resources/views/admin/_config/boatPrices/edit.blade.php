@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.configBoatPrices.index') }}"/>
		<x-form method="post" :action="route('admin.configBoatPrices.update', $configBoatPrice)" class="w-half mt-3">
			@method('put')
			@bind($configBoatPrice)
			<x-form-input id="name" name="name" label="Name" placeholder="Name" required/>
			<x-form-select id="saison_date_id" name="saison_date_id" label="Saison" placeholder="Welche Saison?"
						   :options="$optionsSaisonDates" required/>
			<div class="my-3">
				<span>Vom {{ $configBoatPrice->saison->strFrom }}</span>
				<span class="px-2">Bis {{ $configBoatPrice->saison->strUntil }}</span>
			</div>
			<x-form-select id="price_type_id" name="price_type_id" label="Preis Typ" placeholder="Welche Preis Typ?"
						   :options="$optionsPriceTypes" required/>
			<x-form-input type="number" step="0.01" min="0" id="price_factor" name="price_factor"
						  label="Faktor für Preisberechnung" placeholder="Faktor für Preisberechnung" required/>
			@endbind
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection

