@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.config.port.index', )" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form method="post" :action="route('admin.config.port.store')" class="w-full lg:w-1/2">
            <x-form-input id="name" name="name" label="Name" placeholder="Wie heißt die Saison?" />
            <x-form-input id="street" name="street" label="Strasse u. Hausnummer" />
            <x-form-input id="location" name="location" label="Ort/Stadt" />
            <x-form-input id="postcode" name="postcode" label="PLZ" />
            <x-form-input type="email" id="email" name="email" label="Email-Adresse" />
            <x-form-input id="phone" name="phone" label="Fon" />
            <x-form-input type="number" step="0.000001" id="lat" name="lat" label="Latitude" />
            <x-form-input type="number" step="0.000001" id="lng" name="lng" label="Longitude" />
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
        <div id="map"></div>
    </div>
@endsection

@push('inline-scripts')
    <script>
		$(document).ready(() => {
			const map = Geo.initMap('map');
			map.on('move', ({latlng}) => {
				let lat = document.getElementById('lat'),
                    lng = document.getElementById('lng');
				lat.value(latlng.lat);
				lng.value(latlng.lng);
            });
		})
    </script>
@endpush

