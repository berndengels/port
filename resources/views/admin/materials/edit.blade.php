@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.materials.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form method="post" :action="route('admin.materials.update', $material)" class="w-full lg:w-1/2">
            @method('put')
            @bind($material)
            <x-form-select name="material_category_id" label="Kategorie" :options="$categories" required />
            <x-form-select name="price_type_id" label="Preis-Type" :options="$priceTypes" required />
            <x-form-input name="name" label="Name" required />
            <x-form-input type="number" step="0.1" name="price_per_unit" label="Preis per Einheit" required />
            <x-form-input type="number" step="0.1" name="fertility" label="Ergiebigkeit" />
            <x-form-select name="fertility_unit" label="Einheiten der Ergiebigkeit" :options="$fertilityUnits" />
            <x-form-select name="fertility_per" label="Ergiebigkeit pro" :options="$fertilityPers" />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

