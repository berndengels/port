require('leaflet-imageoverlay-rotated');

const BerthsMapCalculationMixin = {
	methods: {
		setDataOverlay(data) {
			if (data) {
				const options = {
					radius: this.pointRadius,
					weight: 0,
					stroke: false,
					color: "#fff",
					fillOpacity: 1,
				};
				this.markers = data.map(el => {
					try {
						options.fillColor = ("boat" == el.category.name) ? "#f00" : "#00a";
						let m = L.circleMarker([el.lat, el.lng], options),
							text = (new L.tooltip({
								permanent: true,
								direction: 'center',
								className: 'circle-marker-text ' + el.category.name
							}))
							.setLatLng([el.lat, el.lng])
							.setContent("<span>" + el.number ?? 'X' + "</span>")
						;

						if (text) {
							m.bindTooltip(text)
						}
						m.on('click', (e) => {
							this.select(el);
							emitter.emit('point:selected', {data: el})
						});
						return m;
					} catch (err) {
						console.error(err);
						return false
					}
				});
				if (this.featureGroup && this.map.hasLayer(this.featureGroup)) {
					this.featureGroup.removeFrom(this.map)
				}
				this.featureGroup = L.featureGroup(this.markers, {bubblingMouseEvents: false});
				this.featureGroup.addTo(this.map);
			}
			return null;
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
				modus = parseInt(calcData.modus),
				pointCount = parseInt(calcData.count),
				end = start + pointCount - 1,
				distanceBetweenPoints = distance / pointCount,
				lat1 = parseFloat(latLng1.lat),
				lng1 = parseFloat(latLng1.lng),
				lat2 = parseFloat(latLng2.lat),
				lng2 = parseFloat(latLng2.lng),
				num, k, c;

			for (num = start, k = 1, c = 0; c < pointCount; k++, c++) {
				if (c > 0) {
					1 === modus ? num++ : num += 2
				}
				let t = (distanceBetweenPoints * k - distanceBetweenPoints / 2) / distance,
					latitude = (1 - t) * lat1 + t * lat2,
					longitude = (1 - t) * lng1 + t * lng2,
					latLng, point;
				try {
					latLng = new L.LatLng(latitude, longitude);
					if(latLng) {
						point = this.map.latLngToLayerPoint(latLng);
					}

				} catch (err) {
					console.error(err);
					return null;
				}
				data.push({
					berth_category_id: calcData.berth_category_id,
					dock_id: calcData.dock_id,
					lat: latLng.lat,
					lng: latLng.lng,
					w: this.w,
					h: this.h,
					x: point.x,
					y: point.y,
					number: num,
					width: calcData.width ?? parseFloat(distanceBetweenPoints).toFixed(1),
					length: calcData.length,
					daily_price: calcData.daily_price,
					enabled: calcData.enabled,
				});
			}
			return data;
		},

		imageOverlay() {
			const topLeft = L.latLng(54.02663557205177, 13.910246860670147),
				topRight = L.latLng(54.02554842560438, 13.913025141712534),
				bottomLeft = L.latLng(54.02617235660544, 13.909715788931882),
				bounds = L.latLngBounds(topLeft, topRight);


			return L.imageOverlay.rotated(this.mainImage, topLeft, topRight, bottomLeft, {
				opacity: this.mainImageOpacity,
				interactive: true,
//				attribution: "&copy; Yachtlieger Netzelkow"
			});
		},

		handleZoomChange({map: map, oData: oData, oImage: oImage} = {}) {
			map.on('zoomend', () => {
				if (map.getZoom() < this.minLayerZoom) {
					if (oData && map.hasLayer(oData)) {
						oData.removeFrom(map)
					}
					if (oImage && map.hasLayer(oImage)) {
						oImage.removeFrom(map)
					}
				} else {
					if (oData && !map.hasLayer(oData)) {
						oData.addTo(map)
					}
				}
			});
		},
	},
};
export default BerthsMapCalculationMixin
