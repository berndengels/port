import * as L from 'leaflet'
import axios from "axios";
require('leaflet-providers');
require('leaflet-imageoverlay-rotated');
require('leaflet-draw/dist/leaflet.draw');

class Geo {
	map = null;
	features = [];
	mainLat = 54.025907;
	mainLng = 13.911250;
	mainZoom = 18;
	mainOptions = {
//		drawControl: true,
	};
	mainImage = '/img/steg_netzelkow.png';
	mainImageOpacity = 0.4;

	berthMap = (elemID, data = []) => {
		this.map = this.initMap(elemID);
		this.features = this.featuresFromData(data);

		const drawControl = this.getDrawControl();
		this.map.addControl(drawControl);
		this.handleDrawControlEvents();

		const dataOverlay = this.getDataOverlay();
		if(dataOverlay) {
			dataOverlay.addTo(this.map)
		}

		const oImage = this.imageOverlay();
		if(oImage) {
			oImage.addTo(this.map);
		}

		this.handleZoomChange( {oData: dataOverlay, oImage: oImage})
	};

	handleZoomChange = ({oData: oData, oImage: oImage} = {}) => {
		this.map.on('zoomend', () => {
			if(this.map.getZoom() < 16) {
				if(oData) {
					oData.removeFrom(this.map)
				}
				if(oImage) {
					oImage.removeFrom(this.map)
				}
			} else {
				if(oData) {
					oData.addTo(this.map)
				}
				if(oImage) {
					oImage.addTo(this.map)
				}
			}
		});
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

	featuresFromData = (data) => {
		if(data.length > 0) {
			return data.map(item => {
				return this.toFeatures({
					point: new L.LatLng(item.lat, item.lng),
					id: item.id,
					number: item.number,
					width: item.width,
					length: item.length,
					dailyPrice: item.daily_price,
				})
			});
		}
		return null
	};
	getDrawControl = () => {
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
	};
	handleDrawControlEvents = () => {
		this.map.on('draw:drawstart', (e) => {
			$('#frm').show();
		});
		this.map.on('draw:created', ({layer}) => {
			$('#frm').hide();
			console.info("created", layer.getLatLngs());
			const pointStart = layer.getLatLngs()[0],
				pointEnd = layer.getLatLngs()[1],
				$btnStore = $(btnStore),
				prefix = $('#prefix','form').val(),
				start = parseInt($('#start','form').val()),
				end = parseInt($('#end','form').val()),
				vWidth = $('#width','form').val(),
				vLength = $('#length','form').val(),
				vDailyPrice = $('#dailyPrice','form').val(),
				width = "" !== vWidth ? parseFloat(vWidth) : null,
				length = "" !== vLength ? parseFloat(vLength) : null,
				dailyPrice = "" !== vDailyPrice ? parseFloat(vDailyPrice) : null,
				params = {
					latLng1: pointStart,
					latLng2: pointEnd,
					prefix: prefix,
					start: start,
					end: end,
					width: width,
					length: length,
					dailyPrice: dailyPrice,
				};

			this.features.push(this.findEquidistantPoints(params));
		});
	};
	handlePointToLayer = (feature, latlng) => {
		const cMarker = L.circleMarker([latlng.lat, latlng.lng], {
			radius: feature.properties.radius,
			weight: 1,
			stroke: true,
			color: "#080",
			fillColor: "#fff",
			fillOpacity: 1,
			attribution: "Liegeplatz",
		});
		cMarker.on('click', (e) => {
		});
		return cMarker;
	};

	handleEachFeature = (feature, layer) => {
		const text = L.tooltip({
				permanent: true,
				direction: 'center',
				className: 'text'
			})
			.setContent(feature.properties.text)
			.setLatLng(layer.getLatLng());

		if(this.map.getZoom() > 16 ) {
			text.addTo(this.map);
		}

		let table = "<ul>";
		table += "<li>Nummer: " + feature.properties.text + "</li>";
		table += "<li>Breite: " + feature.properties.width + "m</li>";
		table += "<li>Länge: " + feature.properties.length + "m</li>";

		if(feature.properties.daily_price) {
			table += "<li>Tagespreis: " + feature.properties.daily_price + " €</li>";
		}
		table += "</ul>";

		const text2 = new L.tooltip({
				direction: 'top',
				className: 'text'
			})
			.setContent(table)
			.setLatLng(layer.getLatLng());

		layer.bindTooltip(text2);
	};

	getDataOverlay = () => {
		if(this.features && this.features.length > 0) {
			return L.geoJson(this.features, {
				pointToLayer: (feature, latlng) => this.handlePointToLayer(feature, latlng),
				onEachFeature: (feature, layer) => this.handleEachFeature(feature, layer),
			})
		}
		return null
	};

	imageOverlay = () => {
		const topLeft  = L.latLng(54.02663557205177, 13.910246860670147),
			topRight   = L.latLng(54.02554842560438, 13.913025141712534),
			bottomLeft = L.latLng(54.02617235660544, 13.909715788931882);

		return L.imageOverlay.rotated(this.mainImage, topLeft, topRight, bottomLeft,{
			opacity: this.mainImageOpacity,
			interactive: true,
			attribution: "&copy; Yachtlieger Netzelkow"
		});
	};

	measure = (latLng1, latLng2) => {  // generally used geo measurement function
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
	};

	findEquidistantPoints({ latLng1, latLng2, start, end, prefix = "", width = null, length, dailyPrice } = {}) {
		let features = [],
			pointCount = end - start + 1,
			displacement = this.measure(latLng1, latLng2),
			distanceBetweenPoints = displacement / pointCount,
			i,k;

		for (i = start, k = 1; i <= end; i++, k++) {
			let t = (distanceBetweenPoints * k - distanceBetweenPoints / 2) / displacement,
				latLng = new L.LatLng(
					(1 - t) * latLng1.lat + t * latLng2.lat,
					(1 - t) * latLng1.lng + t * latLng2.lng
				);
			features.push(this.toFeatures({
				point: latLng,
				number: i,
				prefix: prefix,
				start: start,
				end: end,
				width: width ?? parseFloat(distanceBetweenPoints).toFixed(1),
				length: length,
				dailyPrice: dailyPrice,
			}));
		}

		return features
	}

	toFeatures = ({point, number, id= null, prefix = "", radius = 12, width, length, dailyPrice } = {}) => {
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
				"text": prefix + number,
				"radius": radius,
				"width": width,
				"length": length,
				"daily_price": dailyPrice,
				"enabled": true,
			}
		}
	}
}
export default Geo;
