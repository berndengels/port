@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.boatDocks.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form name="frm" method="post" :action="route('admin.boatDocks.update', $boatDock)" class="w-full lg:w-1/2">
            @method('put')
            @bind($boatDock)
            <x-form-select name="name" label="Steg Nummer" :options="$dockNumbers" />
            <x-form-input name="length" type="number" step="1" min="1" label="Steg Länge" />
            <x-form-input name="min_box_length" type="number" step="1" min="1" label="min. Box-Länge" />
            <x-form-input name="max_box_length" type="number" step="1" min="1" label="max. Box-Länge" />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

