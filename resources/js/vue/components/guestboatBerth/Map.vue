<template>
    <div>
        <div id="mapBerths"></div>
        <Sidebar id="sidebar">
            <FormCalculateBerths
                @closeCalcForm="closeCalcForm"
            />
        </Sidebar>
        <div class="m-5">
            <MyButton inline="true">update all</MyButton>
            <MyButton inline="true">remove all</MyButton>
        </div>
    </div>
</template>

<script>
import * as L from "leaflet";
require('leaflet-providers');
require('leaflet-imageoverlay-rotated');
require('leaflet-sidebar/src/L.Control.Sidebar');
require('leaflet.fullscreen/Control.FullScreen');
require('leaflet-ruler/src/leaflet-ruler');
import {mapActions, mapGetters} from "vuex";
import MyButton from "v@/components/form/MyButton";
import BerthsMapCalculationMixin from "v@/mixins/berthsMapCalculation";
import FormCalculateBerths from "v@/components/guestboatBerth/FormCalculateBerths";
require('v@/controls/drawline');

export default {
    name: "Map",
    components: {FormCalculateBerths, MyButton},
    mixins: [BerthsMapCalculationMixin],
    props: ['data','portData'],
    data() {
        return {
            id: "mapBerths",
            mainLat: null,
            mainLng: null,
            mainZoom: 18,
            minLayerZoom: 17,
            pointRadius: 12,
            map: null,
            sidebar: null,
            line: null,
            showCalcForm: false,
            markers: [],
            featureGroup: null,
        }
    },
    mounted() {
        if(this.portData) {
            this.mainLat = this.portData.lat;
            this.mainLng = this.portData.lng;
            this.initMap()
        }
    },
    computed: {
        ...mapGetters({
            docks: "guestboatBerth/docks",
            calcData: "guestboatBerth/calcData",
            selected: "guestboatBerth/selected",
            selectedDock: "guestboatBerth/selectedDock",
        }),
    },
    methods: {
        initMap() {
            this.map = this.getMap();
            this.markers = this.setDataOverlay(this.data);
//            this.markers.forEach(el => el.addTo(this.map))
            this.featureGroup = L.featureGroup(this.markers, {bubblingMouseEvents: false});
            this.featureGroup.addTo(this.map);

            this.sidebar = L.control.sidebar('sidebar', {
                closeButton: false,
                position: 'right'
            });
            this.map.addControl(this.sidebar);
            this.map.addControl(L.control.drawLine({
                sidebar: this.sidebar,
                calcData: this.calcData,
                featureHandler: (p) => this.handleFeature(p)
            }));
//            this.handleZoomChange({map: this.map, oData: this.overlayData, oImage: oImage})
//            this.handleZoomChange({map: this.map, oData: this.overlayData});
            emitter.on('data:updated', ({data}) => {
/*
                if(data) {
                    this.data = data;
                    this.featherGroup.clearLayers();
                    this.markers = this.setDataOverlay(this.data);
                    this.featherGroup = L.featureGroup(this.markers, {bubblingMouseEvents: false});
                    this.map.clearLayers();
                    this.featherGroup.addTo(this.map);
                    alert('OK');
//                    this.refill(data);
                }
*/
            });
            emitter.on('point:selected', ({data}) => {
                this.select(data);
                this.$emit('showEditForm', true)
            });

        },

        handleFeature(points) {
            if(points && 2 === points.length) {
                let data = this.findEquidistantPoints(points[0], points[1], this.calcData);
                console.info("new data", data);
                if(data) {
                    this.addData(data);
                    if(this.featureGroup) {
                        this.featureGroup.clearLayers();
                    }
                    this.markers = this.setDataOverlay(data);
//                    console.info("featureGroup", this.featureGroup);
                    this.featureGroup = L.featureGroup(this.markers, {bubblingMouseEvents: false});
//                    this.map.clearLayers();
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
        ...mapActions({
            select: "guestboatBerth/select",
            refill: "guestboatBerth/refill",
            update: "guestboatBerth/update",
            store: "guestboatBerth/store",
            detroy: "guestboatBerth/detroy",
            addData: "guestboatBerth/addData",
        }),
    }
}
</script>

<style scoped>
#mapBerths {
    width: 100%;
    height: 600px !important;
    border: 1px solid #999;
}
</style>
