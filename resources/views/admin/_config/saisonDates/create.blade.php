@extends('layouts.main')

@section('main')
    <div>
        <x-btn-back route="{{ route('admin.config.saisonDates.' . (isset($route) ? $route : 'index') ) }}" />
        <x-form method="post" :action="route('admin.config.saisonDates.store')" class="w-half mt-3">
            <x-form-input id="name" name="name" label="Name" placeholder="Wie heißt die Saison?" required />
            <x-form-input type="date" id="from" name="from" min="{{ \Carbon\Carbon::today()->format('Y') }}-01-01" max="{{ \Carbon\Carbon::today()->addYear()->format('Y-m-d') }}" label="Von" required />
            <x-form-input type="date" id="until" name="until" min="{{ \Carbon\Carbon::today()->format('Y') }}-01-01" max="{{ \Carbon\Carbon::today()->addYear()->format('Y-m-d') }}" label="Bis" required />
            <div class="mt-2">
                <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

