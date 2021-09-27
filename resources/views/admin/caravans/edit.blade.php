@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.caravans.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form action="{{ route('admin.caravans.update', ['caravan' => $caravan->id]) }}" class="w-full lg:w-1/2">
            @method('put')
            @bind($caravan)
            <x-form-select name="country_id" label="Herkunftsland" :options="$countries" />
            <x-form-input name="carnumber" label="Autokennzeichen" required />
            <x-form-input name="carlength" label="Länge" required />
            <x-form-input type="email" name="email" label="Email" />
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
            @endbind
        </x-form>
    </div>
@endsection

