@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.serviceRequests.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form method="post" :action="route('admin.serviceRequests.update', $serviceRequest)" class="w-full lg:w-1/2">
            @method('put')
            @bind($serviceRequest)
            <x-form-select name="boat_id" label="Kunde" :options="$boats" required />
            <x-form-select name="services[]" label="Services" :options="$services" class="flexy" size="10" many-relation multiple />
            <x-form-input name="description" label="Beschreibung" required />
            <x-form-checkbox name="done" label="Erledigt" />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

