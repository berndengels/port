@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.config.entityTypes.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form method="post" :action="route('admin.config.entityTypes.update', $entityType)" class="w-full lg:w-1/2">
            @method('put')
            @bind($entityType)
            <x-form-input id="model" name="model" label="Entity Model" placeholder="Welches Model?" required />
            <x-form-select name="priceComponents[]" label="Services" :options="$optionsPriceComponents" class="flexy" size="10" many-relation multiple />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

