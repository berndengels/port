import * as L from 'leaflet'
require('leaflet-providers');

class Geo {
	constructor(lat = null, lng= null, zoom = 16) {
		if(lat && lng && zoom) {
			this.position = L.latLng(lat, lng);
			this.zoom = zoom
		}
	}
	lat = 54;
	lng = 13;
	zoom = 8;
	position = null;
	marker = null;
	map = null;
	mainOptions = {
		doubleClickZoom: false,
	};
	icon = new L.Icon({
		iconUrl: '/images/vendor/leaflet/dist/marker-icon.png',
		iconSize:     [25, 41], // size of the icon
		iconAnchor:   [12, 41], // point of the icon which will correspond to marker's location
		popupAnchor:  [0, -24] // poi
	});
	initMap = (elemID) => {
		this.map = L.map(elemID, this.mainOptions).setView([this.lat, this.lng], this.zoom);
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 19,
			attribution: '© OpenStreetMap'
		}).addTo(this.map);

		L.tileLayer.provider('OpenStreetMap.DE').addTo(this.map);
		L.tileLayer.provider('OpenSeaMap').addTo(this.map);

		if(this.position) {
			this.map.setView(this.position, this.zoom);
			this.setMarker(this.position)
		}
		return this;
	};
	setMarker = (coord) => {
		this.marker = L.marker(coord, {icon: this.icon}).addTo(this.map);
		this.marker.addTo(this.map);
		return this;
	}
}
export default Geo;
