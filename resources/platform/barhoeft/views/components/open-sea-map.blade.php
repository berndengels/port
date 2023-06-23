<div id="map-widget" class="flex-item-dashboard p-0 widget open-sea-map"></div>

@push('inline-scripts')
	<script>
		var
			lat = {{ $lat }},
			lng = {{ $lng }},
			zoom = {{ $zoom }},
			coord = [lat, lng],
			appName = "{{ config('app.name') }}";

		function showMap() {
			var map = L.map('map-widget').setView(coord, zoom),
				myIcon = new L.Icon({
					iconUrl: '/images/vendor/leaflet/dist/marker-icon.png',
					iconSize: [25, 41], // size of the icon
					iconAnchor: [-20, 65], // point of the icon which will correspond to marker's location
					popupAnchor: [0, -24] // poi
				});
			new L.marker(coord, {icon: myIcon})
				.addTo(map)
				.bindPopup(appName);

			L.tileLayer.provider('OpenStreetMap.DE').addTo(map);
			L.tileLayer.provider('OpenSeaMap').addTo(map)
		}

		$(document).ready(() => {
			showMap()
		});

	</script>
@endpush

@push('styles')
	<link rel="stylesheet" href="{{ mix('css/leaflet.css') }}"/>
@endpush
@push('scripts')
	<script type="text/javascript" src="{{ mix('js/leaflet.js') }}"></script>
	<script type="text/javascript" src="{{ mix('js/leaflet-providers.js') }}"></script>
@endpush
