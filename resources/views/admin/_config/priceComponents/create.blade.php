@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.config.priceComponents.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form method="post" :action="route('admin.config.priceComponents.store')" class="w-full lg:w-1/2">
            <x-form-input id="name" name="name" label="Name" placeholder="Name der Preis Komponente" required />
            <x-form-select id="config_service_id" name="config_service_id" label="Service Art" placeholder="Welche Service?" :options="$optionsServices" />
            <x-form-select id="price_type_id" name="price_type_id" label="Preis Typ" placeholder="Welche Preis Typ?" :options="$optionsPriceTypes" required />
            <x-form-input id="key" name="key" label="Key" required />
            <x-form-input type="number" min="0" step="1" id="unit_inclusive" name="unit_inclusive" label="Wieviel ist inklusive" placeholder="Wieviel Einheiten sind inklusive im Preis" />
            <x-form-input type="number" min="0" step="0.01" id="unit_price" name="unit_price" label="Preis pro Einheit" placeholder="Preis pro Eineit in €" required />
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

