import mapboxgl from '!mapbox-gl';
import * as L from "leaflet";

const BerthsMapCalculationMixin = {
	data() {
		return {
			map: null,
			sidebar: null,
			markers: [],
			line: null,
			featherGroup: null,
			mainOptions: {
				doubleClickZoom: false,
				fullscreenControl: true,
				fullscreenControlOptions: {
					position: 'topleft'
				},
			},
			rulerOptions: {
				position: 'topright',         // Leaflet control position option
				circleMarker: {               // Leaflet circle marker options for points used in this plugin
					color: 'red',
					radius: 2
				},
				lineStyle: {                  // Leaflet polyline options for lines used in this plugin
					color: 'red',
					dashArray: '1,6'
				},
				lengthUnit: {                 // You can use custom length units. Default unit is kilometers.
					display: 'meters',              // This is the display value will be shown on the screen. Example: 'meters'
					decimal: 1,                 // Distance result will be fixed to this value.
					factor: 1000,               // This value will be used to convert from kilometers. Example: 1000 (from kilometers to meters)
					label: 'Distance:'
				},
				angleUnit: {
					display: '&deg;',           // This is the display value will be shown on the screen. Example: 'Gradian'
					decimal: 2,                 // Bearing result will be fixed to this value.
					factor: null,                // This option is required to customize angle unit. Specify solid angle value for angle unit. Example: 400 (for gradian).
					label: 'Bearing:'
				}
			},
			mainImage: '/img/steg_netzelkow.png',
			mainImageOpacity: 0.4,
		}
	},
	methods: {
		getMap(latlng) {
			const map = L.map(this.id, this.mainOptions).setView([this.mainLat, this.mainLng], this.mainZoom);
			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				maxZoom: 19,
				attribution: '© OpenStreetMap'
			}).addTo(map);

			L.control.ruler(this.rulerOptions).addTo(map);

			mapboxgl.accessToken = process.env.MIX_MAPBOX_TOKEN;
			const mapboxOptions = {
				accessToken: process.env.MIX_MAPBOX_TOKEN,
				tileSize: 512,
				maxZoom: this.maxZoom,
				zoomOffset: -1,
				id: 'mapbox/satellite-streets-v11',
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

		setDataOverlay(data) {
			if(data) {
				const options = {
					radius: this.pointRadius,
					weight: 1,
					stroke: true,
					color: "#c00",
					fillColor: "#fff",
					fillOpacity: 1,
				};

				return data.map(el => {
					try {
						let m = L.circleMarker([el.lat, el.lng], options),
							text = (new L.tooltip({
								permanent: true,
								direction: 'center',
								className: 'circle-marker-text'
							}))
							.setLatLng([el.lat, el.lng])
							.setContent("<span>" + el.number ?? 'X' + "</span>")
						;

						if(text) {
							m.bindTooltip(text)
						}
						/*
											m.on('click', (e) => {
												e.target.off("click");
						//						this.select(el);
												emitter.emit('point:selected', {data: el})
											});
						*/
						return m;
					} catch(err) {
						console.error(err);
						return false
					}
				});
			}
			return null;
		},

		updateDataOverlay(data) {
			if(this.overlayData && data) {
				this.overlayData.addData(data)
			}
		},

		getDistance(latLng1, latLng2) {
			const
				lat1 = latLng1.lat,
				lng1 = latLng1.lng,
				lat2 = latLng2.lat,
				lng2 = latLng2.lng,

				R = 6378.137, // Radius of earth in KM
				PI = Math.PI,
				dLat = lat2 * PI / 180 - lat1 * PI / 180,
				dLng = lng2 * PI / 180 - lng1 * PI / 180,
				sinDLat = Math.sin(dLat / 2),
				sinDLng = Math.sin(dLng / 2),
				a = sinDLat * sinDLat +
					Math.cos(lat1 * PI / 180) * Math.cos(lat2 * PI / 180) *
					sinDLng * sinDLng,
				c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)),
				d = R * c;

			return d * 1000; // meters
		},

		findEquidistantPoints(
			latLng1,
	        latLng2,
			calcData
		) {
			let data = [],
				distance = this.getDistance(latLng1, latLng2),
				start = parseInt(calcData.start),
				pointCount = parseInt(calcData.count),
				end = start + pointCount,
				modus = calcData.modus,
				distanceBetweenPoints = distance / pointCount,
				lat1 = parseFloat(latLng1.lat),
				lng1 = parseFloat(latLng1.lng),
				lat2 = parseFloat(latLng2.lat),
				lng2 = parseFloat(latLng2.lng),
				i, k, c;
/*
			console.info("distance", distance)
			console.info("pointCount", pointCount)
			console.info("distanceBetweenPoints", distanceBetweenPoints)
			console.info("start", calcData.start)
			console.info("end", calcData.end)
*/
			for (i = start, k = 1, c = 0; i <= end; i++, k++, c++) {
				if(modus && c > 0) {
					switch(modus) {
						case 'even':
							if( c%2 === 1) {
								continue;
							}
							break;
						case 'odd':
							if( c%2 === 0) {
								continue;
							}
							break;
					}
				}
//				console.info("loop", i)
				let t = (distanceBetweenPoints * k - distanceBetweenPoints / 2) / distance,
					latitude = (1 - t) * lat1 + t * lat2,
					longitude = (1 - t) * lng1 + t * lng2,
					latLng;
				try {
					latLng = new L.LatLng(latitude, longitude);
				} catch(err) {
					console.info("latLng Error", err.toString());
					console.info("t", t);
					console.info("latitude", latitude);
					console.info("longitude", longitude);
					return null;
				}
				data.push({
					point: latLng,
					lat: latLng.lat,
					lng: latLng.lng,
					number: i,
					boat_dock_id: calcData.boat_dock_id,
					width: calcData.width ?? parseFloat(distanceBetweenPoints).toFixed(1),
					length: calcData.length,
					daily_price: calcData.daily_price,
					enabled: calcData.enabled,
				});
			}

//			console.info("data", data)
			return data;
		},

		imageOverlay() {
			const topLeft = L.latLng(54.02663557205177, 13.910246860670147),
				topRight = L.latLng(54.02554842560438, 13.913025141712534),
				bottomLeft = L.latLng(54.02617235660544, 13.909715788931882);

			return L.imageOverlay.rotated(this.mainImage, topLeft, topRight, bottomLeft, {
				opacity: this.mainImageOpacity,
				interactive: true,
				attribution: "&copy; Yachtlieger Netzelkow"
			});
		},

		handleZoomChange({map: map, oData: oData, oImage: oImage} = {}) {
			map.on('zoomend', () => {
				if (map.getZoom() < this.minLayerZoom) {
					if (oData) {
						map.removeLayer(oData);
						oData.clearLayers()
						//oData.removeFrom(map)
					}
					if (oImage) {
						map.removeLayer(oImage);
						oImage.clearLayers()
//						oImage.removeFrom(map)
					}
				} else {
					if (oData) {
						oData.addTo(map)
					}
					if (oImage) {
						oImage.addTo(map)
					}
				}
			});
		},
	},
};
export default BerthsMapCalculationMixin
