@extends('layouts.main')

@section('main')
    <div>
        <x-btn-back route="{{ route('admin.services.index') }}" />
        <x-form method="post" :action="route('admin.services.store')" class="w-half mt-3">
            <x-form-input name="name" label="Beschreibung" required />
            <x-form-select name="materials[]" label="Material" :options="$materials" class="flexy" size="10" many-relation multiple />
            <x-form-select name="price_type_id" label="Arbeits-Preis-Type" :options="$priceTypes" required />
            <x-form-input type="number" min="1" step="1" name="quantity" default="1" label="Anzahl" />
            <x-form-input type="number" step="0.1" name="price" label="Arbeits Preis" required />
            <x-form-select name="service_category_id" label="Kategorie" :options="$categories" required />
            <div class="mt-2">
                <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

