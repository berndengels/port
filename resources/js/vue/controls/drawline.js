import * as L from "leaflet";

L.Control.DrawLine = L.Control.extend({
	includes: L.Evented.prototype || L.Mixin.Events,
	options: {
		position: 'topleft',
		class: 'leaflet-drawLine',
		activeClass: 'active',
	},
	_options: {},
	_sidebar: null,
	_line: null,
	_drawPositions: [],
	_drawToggle: false,
	_markers: new L.layerGroup(),
	_calcData: null,
	_featureHandler: null,
	_container: null,
//	sidebar: this.sidebar,
	initialize: function ({
							  map: map,
							  sidebar: sidebar,
							  calcData: calcData,
							  options: options = null,
							  featureHandler: callback,
						  } = {}) {
		this._sidebar = sidebar;
		this._calcData = calcData;
		this._options = L.setOptions(this, options ?? this.options);
		this._featureHandler = callback;
		// Create sidebar container
		this._container = L.DomUtil.create('div', this._options.class + ' ' + this._options.position);
		this._container.innerHTML = '<i class="fas fa-edit"></i>';
		this._container.title = "Draw Line";
	},
	onAdd: function (map) {
		map._controlContainer.insertBefore(this._container, map._controlContainer.firstChild);
		return this._container;
	},
	removeFrom: function (map) {
		return this;
	},
	_handleDraw: function (map, e) {
	},
});

L.control.drawLine = function ({
								   sidebar: sidebar,
								   calcData: calcData,
								   options: options = null,
								   featureHandler: callback
							   } = {}) {
	return new L.Control.DrawLine(...arguments);
};
