@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.config.saisonRents.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form method="post" :action="route('admin.config.saisonRents.store')" class="w-full lg:w-1/2">
            <x-form-input type="text" id="key" name="key" label="Key" required placeholder="Key Name" />
            <x-form-input type="text" id="name" name="name" label="Name" required placeholder="Saison Name" />
            <x-form-input type="number" id="price" name="price" min="0" step="1" label="Preis pro Tag" required placeholder="Preis pro Tag" />
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

