@extends('layouts.main')

@section('main')
    <div>
        <x-btn-back route="{{ route('admin.caravans.index') }}" />
        <x-form method="post" :action="route('admin.caravans.store')" class="w-half mt-3">
            <x-form-select id="country_id" name="country_id" label="Herkunftsland" :options="$countries" default="{{ config('port.main.default.country_id') }}" />
            <x-form-input class="mt-3" name="carnumber" label="Autokennzeichen" required />
            <x-form-input class="mt-3" name="carlength" label="Länge" type="number" step="1" min="1" required />
            <x-form-input class="mt-3" type="email" name="email" label="Email" />
            <div class="mt-3">
                <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

