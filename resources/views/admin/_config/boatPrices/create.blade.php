@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.config.boatPrices.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form method="post" :action="route('admin.config.boatPrices.store')" class="w-full lg:w-1/2">
            <x-form-select id="saison_date_id" name="saison_date_id" label="Saison" placeholder="Welche Saison?" :options="$optionsSaisonDates" required />
            <x-form-select id="price_type_id" name="price_type_id" label="Preis Typ" placeholder="Welche Preis Typ?" :options="$optionsPriceTypes" required />
            <x-form-input type="number" step="0.01" min="0" id="price_factor" name="price_factor" label="Faktor für Preisberechnung" placeholder="Faktor für Preisberechnung" required />
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

