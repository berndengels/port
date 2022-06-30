import * as L from "leaflet";
//require('mapbox-gl/dist/mapbox-gl')
import mapboxgl from '!mapbox-gl';
require('leaflet-providers');
require('leaflet-imageoverlay-rotated');
require('leaflet-draw/dist/leaflet.draw');

const BerthsMapCalculationMixin = {
	data() {
		return {
			map: null,
			mainLat: 54.025907,
			mainLng: 13.911250,
			mainZoom: 18,
			minLayerZoom: 17,
			pointRadius: 12,
			overlayData: null,
			tooltips: [],
			mainOptions: {
//		        drawControl: true,
			},
			mainImage: '/img/steg_netzelkow.png',
			mainImageOpacity: 0.4,
		}
	},
	methods: {
		getMap() {
			const map = L.map(this.id, this.mainOptions).setView([this.mainLat, this.mainLng], this.mainZoom);
			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				maxZoom: 19,
				attribution: '© OpenStreetMap'
			}).addTo(map);

			mapboxgl.accessToken = process.env.MIX_MAPBOX_TOKEN;
			const mapboxOptions = {
				accessToken: process.env.MIX_MAPBOX_TOKEN,
				tileSize: 512,
				maxZoom: this.maxZoom,
				zoomOffset: -1,
				id: 'mapbox/satellite-v9',
			};
			let mapbox = L.tileLayer.provider('MapBox', mapboxOptions),
				openseamap = L.tileLayer.provider('OpenSeaMap');

			const oImage = this.imageOverlay();
			var baseLayers = {
				"Mapbox": mapbox,
				"OpenSeeMap": openseamap,
				"PortImage": oImage,
			};
			L.control.layers(baseLayers).addTo(map);

			return map
		},

		getDrawControl() {
			const drawnItems = new L.FeatureGroup();
			this.map.addLayer(drawnItems);

			return new L.Control.Draw({
				draw: {
					polyline: {
						guidelineDistance: 10,
					},
					polygon: null,
					rectangle: null,
					point: null,
					circle: null,
					circlemarker: null,
					marker: null,
					edit: null,
				},
				edit: {
					featureGroup: drawnItems
				}
			});
		},

		getDataOverlay(data) {
			if(data && data.length > 0) {
				return L.geoJson(data, {
					pointToLayer: (feature, latlng) => this.handlePointToLayer(feature, latlng),
					onEachFeature: (feature, layer) => this.handleEachFeature(feature, layer),
				})
			}
			return null
		},

		handlePointToLayer(feature, latlng) {
			let options = {
				radius: this.pointRadius,
				weight: 1,
				stroke: true,
				color: "#c00",
				fillColor: "#fff",
				fillOpacity: 1,
			};
			emitter.on("geoDataSelected", item => {
				if(feature.properties.id === item.properties.id) {
					options = {
						...options,
						color: "#d00",
						fillColor: "#d00",
					}
				}
			});
			const cMarker = L.circleMarker([latlng.lat, latlng.lng], options);
			cMarker.on('click', () => {
				this.select(feature);
				this.$emit('showEditForm', true)
			});
			return cMarker;
		},

		handleEachFeature(feature, layer) {
			let tooltip = this.getPointTooltip(feature, layer);
			emitter.on("geoDataChanged", item => {
				if(feature.properties.id === item.properties.id) {
					tooltip.setContent(item.properties.number)
				}
			});
			tooltip.addTo(this.map);

			let popup = this.getPointPopup(feature, layer);
			layer.bindTooltip(popup);
		},

		getPointTooltip(feature, layer) {
			let cls = 'text';
			emitter.on("geoDataSelected", item => {
				if(feature.properties.id === item.properties.id) {
					cls += " selected";
					console.info("geoDataSelected", cls)
				}
			});

			return L.tooltip({
					permanent: true,
					direction: 'center',
					className: cls,
				})
				.setContent(feature.properties.number)
				.setLatLng(layer.getLatLng());
		},

		getPointPopup(feature, layer) {
			let html = "<ul>";
			html += "<li>Nummer: " + feature.properties.number + "</li>";
			html += "<li>Breite: " + feature.properties.width + "m</li>";
			html += "<li>Länge: " + feature.properties.length + "m</li>";

			if(feature.properties.daily_price) {
				html += "<li>Tagespreis: " + feature.properties.daily_price + " €</li>";
			}
			html += "</ul>";

			return new L.tooltip({
					direction: 'top',
					className: 'text'
				})
				.setContent(html)
				.setLatLng(layer.getLatLng());
		},

		getDistance(latLng1, latLng2) {
			const
				lat1 = latLng1.lat,
				lng1 = latLng1.lng,
				lat2 = latLng2.lat,
				lng2 = latLng2.lng,

				R  = 6378.137, // Radius of earth in KM
				PI = Math.PI,
				dLat = lat2 * PI / 180 - lat1 * PI / 180,
				dLng = lng2 * PI / 180 - lng1 * PI / 180,
				sinDLat = Math.sin(dLat/2),
				sinDLng = Math.sin(dLng/2),
				a = sinDLat * sinDLat +
					Math.cos(lat1 * PI / 180) * Math.cos(lat2 * PI / 180) *
					sinDLng * sinDLng,
				c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)),
				d = R * c;

			return d * 1000; // meters
		},

		findEquidistantPoints({ latLng1, latLng2, start, end, prefix = "", width = null, length, daily_price } = {}) {
			let data = [],
				pointCount = end - start + 1,
				distance = this.getDistance(latLng1, latLng2),
				distanceBetweenPoints = distance / pointCount,
				i,k;

			for (i = start, k = 1; i <= end; i++, k++) {
				let t = (distanceBetweenPoints * k - distanceBetweenPoints / 2) / distance,
					latLng = new L.LatLng(
						(1 - t) * latLng1.lat + t * latLng2.lat,
						(1 - t) * latLng1.lng + t * latLng2.lng
					);

				data.push(this.toFeatures({
					point: latLng,
					number: i,
					prefix: prefix,
					start: start,
					end: end,
					width: width ?? parseFloat(distanceBetweenPoints).toFixed(1),
					length: length,
					daily_price: daily_price,
				}));
			}
			return data;
		},

		toFeatures({point, number, id= null, prefix = "", width, length, daily_price } = {}) {
			return {
				"type": "Feature",
				"geometry": {
					"type": "Point",
					"coordinates": [point.lng, point.lat]
				},
				"properties": {
					"id": id,
					"number": prefix + number,
					"lat": point.lat,
					"lng": point.lng,
					"width": width,
					"length": length,
					"daily_price": daily_price,
					"enabled": true,
				}
			}
		},

		imageOverlay() {
			const topLeft  = L.latLng(54.02663557205177, 13.910246860670147),
				topRight   = L.latLng(54.02554842560438, 13.913025141712534),
				bottomLeft = L.latLng(54.02617235660544, 13.909715788931882);

			return L.imageOverlay.rotated(this.mainImage, topLeft, topRight, bottomLeft,{
				opacity: this.mainImageOpacity,
				interactive: true,
				attribution: "&copy; Yachtlieger Netzelkow"
			});
		},

		handleZoomChange({map: map, oData: oData, oImage: oImage} = {}) {
			map.on('zoomend', () => {
				if(map.getZoom() < this.minLayerZoom) {
					alert('hide');
					if(oData) {
						map.removeLayer(oData)
						//oData.removeFrom(map)
					}
					if(oImage) {
						map.removeLayer(oImage)
//						oImage.removeFrom(map)
					}
				} else {
					alert('show');
					if(oData) {
						oData.addTo(map)
					}
					if(oImage) {
						oImage.addTo(map)
					}
				}
			});
		},
	},
};
export default BerthsMapCalculationMixin
