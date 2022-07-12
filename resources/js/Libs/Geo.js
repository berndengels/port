import * as L from 'leaflet'
require('leaflet-providers');
require('leaflet-imageoverlay-rotated');
require('leaflet-draw/dist/leaflet.draw');

class Geo {
	map = null;
	mainLat = 54;
	mainLng = 13;
	mainZoom = 8;
	mainOptions = {
//		drawControl: true,
	};

	initMap = (elemID) => {
		const map = L.map(elemID, this.mainOptions).setView([this.mainLat, this.mainLng], this.mainZoom);
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 19,
			attribution: '© OpenStreetMap'
		}).addTo(map);

		L.tileLayer.provider('OpenStreetMap.DE').addTo(map);
		L.tileLayer.provider('OpenSeaMap').addTo(map);
		return map
	};
}
export default Geo;
