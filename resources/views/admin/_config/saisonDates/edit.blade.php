@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.config.saisonDates.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form method="post" :action="route('admin.config.saisonDates.update', $saisonDate)" class="w-full lg:w-1/2">
            @method('put')
            @bind($saisonDate)
            <x-form-input id="name" name="name" label="Name" placeholder="Wie heißt die Saison?" required />
            <x-form-input type="date" id="from" name="from" label="Von" :bind="false" default="{{ $saisonDate->validFrom }}" required />
            <x-form-input type="date" id="until" name="until" label="Bis" :bind="false" default="{{ $saisonDate->validUntil }}" required />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

