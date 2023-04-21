@extends('layouts.main')

@section('main')
    <div>
        <x-btn-back route="{{ route('admin.config.settings.index') }}" />
        <div class="row mt-3">
            <div class="col-sm-12 col-md-4">
                <x-form method="post" :action="route('admin.config.settings.store')" class="w-full">
                    <x-form-input id="name" name="name" label="Name" placeholder="Name der Firma" />
                    <x-form-input id="street" name="street" label="Strasse u. Hausnummer" placeholder="Strasse und Hausnummer" />
                    <x-form-input id="location" name="location" label="Ort/Stadt" placeholder="Ort oder Stadt" />
                    <x-form-input id="postcode" name="postcode" label="PLZ" placeholder="Postleitzahl" />
                    <x-form-input type="email" id="email" name="email" label="Email-Adresse" placeholder="Email Adresse" />
                    <x-form-input id="fon" name="fon" label="Fon" placeholder="Telefon Nummer" />
                    <x-form-input id="bank" name="bank" label="Bank-Institut" placeholder="Ihr Bank-Institut" />
                    <x-form-input id="bic" name="bic" label="BIC" pattern="^([a-zA-Z]){6}([0-9a-zA-Z]){2}([0-9a-zA-Z]{3})?$" title="Ein BIC hat 8 oder 11 Stellen" placeholder="BIC" />
                    <x-form-input id="iban" name="iban" label="IBAN" pattern="^DE\d{2}[ ]\d{4}[ ]\d{4}[ ]\d{4}[ ]\d{4}[ ]\d{2}|DE\d{20}$" placeholder="IBAN" title="Eine deutsche IBAN hat 22 Stellen und beginnt mit DE" />
                    <x-form-input type="number" step="0.1" min="0" id="tax" name="tax" label="MWSt" />
                    <x-form-checkbox id="use_tax" name="use_tax" label="MWSt im Preis ansetzen" default="19" />
                    <x-form-input type="number" step="0.000001" id="lat" name="lat" label="Latitude" />
                    <x-form-input type="number" step="0.000001" id="lng" name="lng" label="Longitude" />
                    <div class="mt-2">
                        <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
                    </div>
                </x-form>
            </div>
            <div class="col-sm-12 col-md-6">
                <div id="map" class="mt-4 ms-sm-0 ms-lg-5 h-75"></div>
            </div>
        </div>
    </div>@endsection

@push('inline-scripts')
<script>
	$(document).ready(() => {
		const lat = document.getElementById('lat'),
			lng = document.getElementById('lng');

        const geo = new Geo();
        geo.initMap('map');
        geo.map.on('dblclick', (e) => {
            lat.value = e.latlng.lat.toFixed(6);
            lng.value = e.latlng.lng.toFixed(6);
            geo.position = e.latlng;
            if(geo.marker) {
                geo.marker.setLatLng(geo.position)
            } else {
                geo.setMarker(geo.position)
            }
        });
	});
</script>
@endpush

