@extends('layouts.main')

@section('main')
    <div>
        <x-btn-back route="{{ route('admin.caravans.index') }}" />
        <x-form action="{{ route('admin.caravans.update', ['caravan' => $caravan->id]) }}" class="w-half mt-3">
            @method('put')
            @bind($caravan)
            <x-form-select name="country_id" label="Herkunftsland" :options="$countries" />
            <x-form-input class="mt-3" name="carnumber" label="Autokennzeichen" required />
            <x-form-input class="mt-3" name="carlength" label="Länge" type="number" step="1" min="1" required />
            <x-form-input class="mt-3" type="email" name="email" label="Email" />
            <div class="mt-3">
                <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
            </div>
            @endbind
        </x-form>
    </div>
@endsection

