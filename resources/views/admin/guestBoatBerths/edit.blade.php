@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.guestBoatBerths.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form name="frm" method="post" :action="route('admin.guestBoatBerths.update', $guestBoatBerth)" class="w-full lg:w-1/3 mt-5">
            @method('put')
            @bind($guestBoatBerth)
            <x-form-checkbox name="enabled" label="Aktiv" />
            <x-form-input name="number" label="Nummer" placeholder="Liegeplatz-Nummer" required />
            <x-form-input name="length" type="number" step="0.1" min="1" label="Länge" placeholder="Länge" required />
            <x-form-input name="width" type="number" step="0.1" min="1" label="Breite" placeholder="Breite" required />
            <x-form-input name="daily_price" type="number" step="1" min="1" label="Tagespreis" placeholder="Tagespreis" />
            <x-form-input name="lat" type="number" step="1" min="1" label="Latitude" placeholder="Latitude" />
            <x-form-input name="lng" type="number" step="1" min="1" label="Longitude" placeholder="Longitude" />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

@push('inline-scripts')
    <script>
    </script>
@endpush
