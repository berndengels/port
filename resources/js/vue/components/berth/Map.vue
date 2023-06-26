<template>
	<div>
		<div :id="id" class="align-content-center"></div>
		<Sidebar id="sidebar">
			<FormCalculateBerths @closeCalcForm="closeCalcForm"/>
		</Sidebar>
		<div class="mt-2">
			<MyButton :inline="true" css="btn btn-danger inline delSoft" @click="removeAll">remove all</MyButton>
			<MyButton :inline="true" css="btn btn-primary inline" @click="saveBackup">Save Backup</MyButton>
			<MyButton :inline="true" css="btn btn-primary inline" @click="loadBackup">Lade Backup</MyButton>
		</div>
	</div>
</template>

<script>
import * as L from "leaflet";

require('leaflet-providers');
require('leaflet-sidebar/src/L.Control.Sidebar');
require('leaflet.fullscreen/Control.FullScreen');
require('leaflet-ruler/src/leaflet-ruler');
require('leaflet-geometryutil/src/leaflet.geometryutil');
require('v@/controls/custom.control');
require('v@/plugins/leaflet.draw-src');

import {mapActions, mapGetters} from "vuex";
import MyButton from "v@/components/form/MyButton";
import BerthsMapCalculationMixin from "v@/mixins/berthsMapCalculation";
import FormCalculateBerths from "v@/components/berth/FormCalculateBerths";
import mOptions from "v@/inc/mOptions";

export default {
	name: "Map",
	components: {FormCalculateBerths, MyButton},
	mixins: [BerthsMapCalculationMixin],
	data() {
		return mOptions
	},
	created() {
		setTimeout(() => {
			if (this.portData && this.portData.lat && this.portData.lng) {
				this.mainLat = this.portData.lat;
				this.mainLng = this.portData.lng;
			}
			this.initMap();
			this.$watch('data', (newData) => {
				this.setDataOverlay(newData)
			})
		}, 2000);
	},
	computed: {
		...mapGetters({
			data: "berth/data",
			portData: "berth/portData",
			docks: "berth/docks",
			categories: "berth/categories",
			calcData: "berth/calcData",
			selected: "berth/selected",
			selectedDock: "berth/selectedDock",
			errors: "berth/errors",
		}),
	},
	methods: {
		initMap() {
			this.map = L.map(this.id, this.mapOptions).setView([this.mainLat, this.mainLng], this.mainZoom);
			const $map = $('#' + this.id);
			this.w = Math.round($map.width());
			this.h = Math.round($map.height());
			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				maxZoom: 19,
				attribution: '©OpenStreetMap'
			}).addTo(this.map);
			L.control.ruler(this.rulerOptions).addTo(this.map);
			const mapboxOptions = {
				accessToken: process.env.MIX_MAPBOX_TOKEN,
				tileSize: 512,
				maxZoom: this.maxZoom,
				zoomOffset: -1,
				id: 'mapbox/satellite-streets-v11',
			};
			var oImage = null;
			if (this.mainImage) {
				oImage = this.imageOverlay();
			}

			const mapbox = L.tileLayer.provider('MapBox', mapboxOptions),
				openSeaMap = L.tileLayer.provider('OpenSeaMap'),
				baseLayers = {
					"Mapbox": mapbox,
					"OpenSeeMap": openSeaMap,
				};

			if (oImage) {
				baseLayers["PortImage"] = oImage;
			}

			L.control.layers(baseLayers).addTo(this.map);
			if (this.data) {
				this.setDataOverlay(this.data);
			}
			this.sidebar = L.control.sidebar('sidebar', {
				closeButton: false,
				position: 'right',
				autoPan: false,
			});
			this.sidebarControlOptions.events.click = (e) => {
				e.preventDefault();
				this.sidebar.toggle();
			};
			this.pointsControlOptions.events.click = () => {
				this.fillPoints()
			};
			this.pointsControl = new L.control.custom(this.pointsControlOptions);
			this.map.addControl(new L.Control.Draw(this.drawOptions));
			this.map.addControl(this.sidebar);
			this.map.addControl(new L.control.custom(this.sidebarControlOptions));
			this.sidebar.hide();
			this.map.on('enterFullscreen', () => {
				this.map.addControl(this.pointsControl);
			});
			this.map.on('exitFullscreen', () => {
				this.map.removeControl(this.pointsControl)
			});
			this.map.on(L.Draw.Event.DRAWSTART, () => {
				window.alert("Bitte erst die Eigenschaften für die anzulegenden Liegeplätze definieren");
				this.sidebar.show();
				this.pointStart = null;
				this.pointEnd = null;
			});
			this.map.on(L.Draw.Event.DRAWVERTEX, ({layers}) => {
				const l = layers.getLayers();
				if (2 === l.length) {
					let [l0, l1] = l;
					this.pointStart = l0.getLatLng();
					this.pointEnd = l1.getLatLng()
				}
			});
			this.map.on(L.Draw.Event.DRAWSTOP, () => {
				try {
					this.setMapPoints([this.pointStart, this.pointEnd])
				} catch (err) {
					console.error(err);
				}
			});
			this.handleZoomChange({map: this.map, oData: this.featureGroup, oImage: oImage})
		},
		setMapPoints(points) {
			if (points && 2 === points.length) {
				const category = this.categories.filter(c => c.id === this.calcData.berth_category_id),
					dock = this.docks.filter(d => d.id === this.calcData.dock_id),
					data = this.findEquidistantPoints(points[0], points[1], this.calcData).map(d => {
						d.category = category
						d.dock = dock
						return d
					});

				if (data) {
					this.addData(data);
					if (this.featureGroup) {
						this.featureGroup.clearLayers();
					}
					this.refill(data);
					this.markers = this.setDataOverlay(data);
					this.featureGroup = L.featureGroup(this.markers, {bubblingMouseEvents: false});
					this.featureGroup.addTo(this.map);
				}
			}
		},
		closeCalcForm() {
			this.sidebar.hide()
		},
		saveCalcForm() {
			this.sidebar.hide()
		},
		removeAll() {
			if (confirm("Wirklich alle Daten löschen?")) {
				this.detroyAll();
				this.featureGroup.clearLayers();
				this.featureGroup.removeFrom(this.map)
			}
			return false;
		},
		fillPoints() {
			const map = this.map,
				points = this.data.map(p => {
					let latLng = new L.latLng(p.lat, p.lng),
						point = map.latLngToContainerPoint(latLng).round();

					return {
						berth_id: p.id,
						w: this.w,
						h: this.h,
						x: point.x,
						y: point.y
					};
				});
			if (confirm(points.length + " Punkte setzen?")) {
				this.setPoints(points);
			}
		},
		...mapActions({
			loadBackup: "berth/loadBackup",
			saveBackup: "berth/saveBackup",
			select: "berth/select",
			refill: "berth/refill",
			update: "berth/update",
			store: "berth/store",
			setPoints: "berth/setPoints",
			detroy: "berth/detroy",
			detroyAll: "berth/detroyAll",
			addData: "berth/addData",
		}),
	}
}
</script>

<style scoped>
#mapBerths {
	width: 100%;
	height: 600px !important;
	background-color: #ccc;
	border: 1px solid #999;
}
</style>
