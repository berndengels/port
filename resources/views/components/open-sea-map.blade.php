
<div id="map" class="flex-item-dashboard p-0 widget open-sea-map"></div>

@push('inline-scripts')
<script>
    var
        lat = {{ $lat }},
	    lng = {{ $lng }},
	    zoom = {{ $zoom }},
        coord = [lat, lng];

	function showMap() {
		var map = L.map('map').setView(coord, zoom),
			myIcon = new L.Icon({
				iconUrl: '/images/icons8-maps-48.png',
				iconSize:     [48, 48], // size of the icon
				iconAnchor:   [24, 48], // point of the icon which will correspond to marker's location
				popupAnchor:  [0, -24] // poi
			});
			new L.marker(coord, {icon: myIcon})
				.addTo(map)
				.bindPopup("<b>Yachtlieger Achterwasser</b>").openPopup()

		L.tileLayer.provider('OpenStreetMap.DE').addTo(map)
		L.tileLayer.provider('OpenSeaMap').addTo(map)
	}
	showMap()
</script>
@endpush

@push('styles')
	<link rel="stylesheet" href="{{ mix('css/leaflet.css') }}" />
@endpush
@push('scripts')
	<script type="text/javascript" src="{{ mix('js/leaflet.js') }}"></script>
	<script type="text/javascript" src="{{ mix('js/leaflet-providers.js') }}"></script>
@endpush
