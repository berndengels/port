@extends('layouts.main')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
    <style>
        #map {
            width: 100%;
            height: 100vh;
            border: 1px solid grey;
        }
    </style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-gpx/1.7.0/gpx.min.js"></script>
@endpush

@section('main')
    <div>
        <div id="map"></div>
    </div>
@endsection

@push('inline-scripts')
    <script>
        const gpxData = '{!! $data !!}',
            map = L.map('map');
		    popup = null,

        L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="http://www.osm.org">OpenStreetMap</a>'
        }).addTo(map);

        const gpx = new L.GPX(gpxData, {async: true})
            .on('loaded', function(e) {
                map.fitBounds(e.target.getBounds());
	            gpx.on('click', (e) => {
					let info = "<ul>";
					info += "<li>Tour Länge</li>";
		            info += "<li>" + Math.round(e.target.get_distance()/1000) + " km</li>";
					info += "</ul>";
					map.fire('route:info', {
						latlng: e.latlng,
                        info: info,
					})
                });

            }).addTo(map);

		    map.on('route:info', ({latlng, info}) => {
				if(popup) {
					map.closePopup()
                }
                popup = new L.Popup()
                    .setLatLng(latlng)
                    .setContent(info)
                    .openOn(map);
            })

    </script>
@endpush

