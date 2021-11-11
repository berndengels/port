@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.services.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form method="post" :action="route('admin.services.update', $service)" class="w-full lg:w-1/2">
            @method('put')
            @bind($service)
            <x-form-input name="name" label="Beschreibung" required />
            <x-form-select name="materials[]" label="Material" :options="$materials" class="flexy" size="10" many-relation multiple />
            <x-form-input type="number" step="0.1" name="price" label="Arbeits Preis" required />
            <x-form-select name="service_category_id" label="Kategorie" :options="$categories" required />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

