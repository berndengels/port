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
            <x-form-submit class="rounded">Speichern</x-form-submit>
            @endbind
        </x-form>
    </div>
@endsection

