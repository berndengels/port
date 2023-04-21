@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.config.priceComponents.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form method="post" :action="route('admin.config.priceComponents.store')" class="w-full lg:w-1/2">
            <x-form-input id="name" name="name" label="Name" placeholder="Wie heißt die Saison?" required />
            <x-form-input type="date" id="from" name="from" label="Von" required />
            <x-form-input type="date" id="until" name="until" label="Bis" required />
            <div class="mt-2">
                <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

