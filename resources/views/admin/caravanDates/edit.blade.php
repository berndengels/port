@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.caravanDates.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form action="{{ route('admin.caravanDates.update', ['caravanDate' => $caravanDate->id]) }}" class="w-full lg:w-1/2">
            @method('put')
            @bind($caravanDate->caravan)
            <x-form-input name="carnumber" label="Autokennzeichen" required />
            <x-form-select name="country_id" label="Herkunftsland" :options="$countries" />
            <x-form-input name="carlength" label="Länge" required />
            <x-form-input type="email" name="email" label="Email" />
            @endbind

            @bind($caravanDate)
            <x-form-input name="from" type="date" label="Von" required :bind="false" :default="$caravanDate->validFrom" />
            <x-form-input name="until" type="date" label="Bis" required :bind="false" :default="$caravanDate->validUntil" />
            <div class="mt-3">
                <x-form-checkbox name="electric" label="Stromanschluß" />
            </div>
            <x-form-input name="persons" label="Anzahl Personen" required />
            <x-form-input name="price" label="Preis" required />
            @endbind

            <x-form-submit class="rounded">Speichern</x-form-submit>
        </x-form>
    </div>
@endsection

