@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.houseboatModels.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form name="frm" method="post" :action="route('admin.houseboatModels.update', $houseboatModel)" class="w-full lg:w-1/2">
            @method('put')

            @bind($houseboatModel)
            <x-form-input name="name" label="Name" required />
            <x-form-input name="space" type="number" step="1" min="1" label="Fläche" required />
            <x-form-input name="floors" type="number" step="1" min="1" label="Stockwerke" required />
            <x-form-input name="sleeping_places" type="number" step="1" min="1" label="max. Personen" required />
            <x-form-input name="peak_season_price" type="number" step="1" min="1" label="Preis Hauptsaison" required />
            <x-form-input name="mid_season_price" type="number" step="1" min="1" label="Preis Zwischensaison" required />
            <x-form-input name="low_season_price" type="number" step="1" min="1" label="Preis Nebensaison" required />
            <x-form-textarea name="description" label="Beschreibung" required />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection
