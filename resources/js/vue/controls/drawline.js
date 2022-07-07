//import * as L from "leaflet";

L.Control.DrawLine = L.Control.extend({
	includes: L.Evented.prototype || L.Mixin.Events,
	options: {
		position: 'topleft',
		class: 'leaflet-drawLine',
		activeClass: 'active',
	},
	_options: {},
	_sidebar: null,
	_drawPositions: [],
	_drawToggle: false,
	_markers: new L.layerGroup(),
	_calcData: null,

//	sidebar: this.sidebar,
	initialize: function({sidebar: sidebar, calcData: calcData, options: options = null, featureHandler: featureHandler} = {}) {
		this._sidebar = sidebar;
		this._calcData = calcData;
		this._options = L.setOptions(this, options ?? this.options);
		// Create sidebar container
		let container = this._container = L.DomUtil.create('div', this._options.class + ' ' + this._options.position);
		container.innerHTML = '<i class="fas fa-edit"></i>';
		container.title = "Draw Line";
	},
	onAdd: function(map) {
		let container = this._container;
		L.DomEvent.on(container, 'click',function (e) {
			e.stopPropagation();
			container.classList.toggle(this._options.activeClass);
			this.drawToggle = !this.drawToggle;
			this.drawToggle ? this._sidebar.show() : this._sidebar.hide();
			this._handleDraw(map, e);
		}, this);
		// Attach sidebar container to controls container
		let controlContainer = map._controlContainer;
		controlContainer.insertBefore(container, controlContainer.firstChild);
		this._map = map;
		return container;
	},
	removeFrom: function(map) {
		let container = this._container;
		// Remove sidebar container from controls container
		let controlContainer = map._controlContainer;
		controlContainer.removeChild(container);
		//disassociate the map object
		this._map = null;
		// Unregister events to prevent memory leak
		L.DomEvent.off(container, 'click', this._handleDrawClick, this);
		return this;
	},
	_handleDraw: function(map, e) {
		e.stopPropagation();
//		this._sidebar.show();
		let stop = false, line, mOptions = {
			radius: 5,
			color: '#f00',
		};
		if(this._drawPositions.length === 0) {
			alert('click to start point, then move mouse to end point and click')
		}

		map.on('draw:start', ({latlng, line}) => {
			alert("draw:start");
			map.on('mousemove', (e) => {
				line.setLatLngs([latlng, e.latlng])
			});
		});
		map.on('draw:complete', ({points}) => {
			alert('line complete');
			map.off('mousemove');
			console.info('calcData', this._calcData);
			const p = featureHandler
		});
		map.on('mousedown', (e) => {
			this._drawPositions.push(e.latlng);
			if(this._drawPositions.length === 1) {
				line = L.polyline(this._drawPositions[0], {
					color: 'red',
				}).addTo(map);
				map.fire('draw:start', { line: line, latlng: this._drawPositions[0] })
			}
			else if(this._drawPositions.length === 2) {
				map.fire('draw:complete', {points: this._drawPositions});

			}
/*
			if(this._drawPositions.length === 0) {
				this._drawPositions.push(e.latlng)
				this._markers.addLayer(new L.circleMarker(e.latlng, mOptions))
				map.updateLayers(this.markers)
				line = L.polyline(this.drawPositions, {
					color: 'red',
				}).addTo(this.map);
				map.on('mousemove', (e) => {
					line.setLatLngs([this.drawPositions[0], e.latlng])
					map.on('mousedown', (e) => {
						this._drawPositions.push(e.latlng)
						this._markers.addLayer(new L.circleMarker(e.latlng, mOptions))
						map.updateLayers(this._markers)

						map.off('mousemove')
						line.clearAll()
						map.removeLayer(markers);
						this._markers.clearLayers();

						const pointStart = this.drawPositions[0],
							pointEnd = this.drawPositions[1],
							params = {
								...this.calcData,
								latLng1: pointStart,
								latLng2: pointEnd,
							};
						let data = this.findEquidistantPoints(params);
//							console.info("new data", data)
						data.forEach(el => this.addData(el));
						this.refill(data);
					})
				})
			}
			else {
				alert("all positions calculated")
			}
*/
		})
	},
});

L.control.drawLine = function ({sidebar: sidebar, calcData: calcData, options: options = null, featureHandler: featureHandler} = {}) {
	return new L.Control.DrawLine(...arguments);
};
