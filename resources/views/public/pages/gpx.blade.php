@extends('layouts.main')

@push('styles')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css"/>
	<style>
        #map {
            width: 100%;
            height: 100vh;
            border: 1px solid grey;
        }

        h1 {
            font-size: 1.5rem;
            font-weight: bold;
            padding-top: 0.5rem;
        }
	</style>
@endpush

@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-gpx/1.7.0/gpx.min.js"></script>
@endpush

@section('header')
	<h1 class="text-center text-blue-900">Map</h1>
@endsection

@section('main')
	<div>
		<div id="map"></div>
	</div>
@endsection

@push('inline-scripts')
	<script>
		window.onload = () => {
			const gpxData = '{!! $data !!}',
				map = L.map('map');

			L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: 'Map data &copy; <a href="http://www.osm.org">OpenStreetMap</a>'
			}).addTo(map);

			const gpx = new L.GPX(gpxData, {
				async: true,
				marker_options: {
					clickable: true,
					parseElements: ['track', 'route', 'waypoint'],
				},
				gpx_options: {
					joinTrackSegments: false
				}
			}).on('loaded', function (e) {
				map.fitBounds(e.target.getBounds());
				const distance = Math.round(e.target.get_distance() / 1000);
				document.querySelector('h1').innerText = "Tourlänge " + distance + " km";
			}).addTo(map);
		}
	</script>
@endpush

