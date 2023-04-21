@extends('layouts.main')

@section('main')
    <div>
        <x-btn-back route="{{ route('admin.config.entities.index') }}" />
        <x-form method="post" :action="route('admin.config.entities.store')" class="w-half mt-3">
            <x-form-select
                    name="model"
                    label="Entity Model"
                    :options="$modelOptions"
                    class="flexy"
            />
            <x-form-select
                    name="priceComponents[]"
                    label="Preis-Komponenten"
                    :options="$optionsPriceComponents"
                    class="flexy"
                    size="10"
                    multiple
                    many-relation
            />
            <div class="mt-2">
                <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

