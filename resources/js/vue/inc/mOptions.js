const mOptions = {
	id: "mapBerths",
	mainImage: '/img/steg_netzelkow.png',
	mainImageOpacity: 0.4,
	mainLat: null,
	mainLng: null,
	mainZoom: 19,
	w: null,
	h: null,
	x: null,
	y: null,
	pointStart: null,
	pointEnd: null,
	minLayerZoom: 18,
	pointRadius: 12,
	map: null,
	sidebar: null,
	line: null,
	showCalcForm: false,
	markers: [],
	featureGroup: null,
	countVertex: 0,
	mapOptions: {
		doubleClickZoom: false,
		fullscreenControl: true,
		fullscreenControlOptions: {
			position: 'topleft'
		},
	},
	sidebarControlOptions: {
		position: 'bottomleft',
		classes: 'control-berth-properties',
		title: 'Liegeplatz Eigenschaften',
		content: '<a type="button" href="#">'
			+ '<i class="far fa-hand-point-right"></i>'
			+ '</a>',
		events: {}
	},
	pointsControlOptions: {
		position: 'topleft',
		classes: 'btn-group-vertical btn-group-sm align-content-center text-center',
		title: 'set Points from LatLngs',
		content: '<button type="button" class="btn btn-default">'
			+ '<i class="fa-solid fa-map-location-dot"></i>'
			+ '</button>',
		style: {
			width: '30px',
			height: '30px',
//          lineHeight: '30px',
			marginLeft: '10px',
			padding: '1px',
			cursor: 'pointer',
			textAlign: 'center',
			borderRadius: '2px',
			color: '#666',
			backgroundColor: '#fff',
			fontSize: '1.0rem',
			border: '1px solid #555',
		},
		events: {}
	},
	pointsControl: null,
	drawControl: null,
	drawOptions: {
		position: 'bottomleft',
		draw: {
			polyline: {
				maxPoints: 2
			},
			polygon: false,
			rectangle: false,
			circle: false,
			marker: false,
			circlemarker: false,
		},
		edit: false
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
}
export default mOptions
