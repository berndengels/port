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
require('leaflet-draw/dist/leaflet.draw');
require('leaflet-sidebar/src/L.Control.Sidebar');
import {mapActions, mapGetters} from "vuex";
import MyButton from "v@/components/form/MyButton";
import BerthsMapCalculationMixin from "v@/mixins/berthsMapCalculation";
import FormCalculateBerths from "v@/components/guestboatBerth/FormCalculateBerths";
require('v@/controls/drawline');

export default {
    name: "Map",
    components: {FormCalculateBerths, MyButton},
    mixins: [BerthsMapCalculationMixin],
    props: ['data'],
    data() {
        return {
            id: "mapBerths",
            map: null,
            sidebar: null,
            showCalcForm: false,
            overlayData: null,
            tooltips: [],
        }
    },
    mounted() {
        this.initMap()
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

            this.overlayData = this.getDataOverlay(this.data);
            if(this.overlayData) {
                this.overlayData.addTo(this.map)
            }

            this.sidebar = L.control.sidebar('sidebar', {
                closeButton: false,
                position: 'right'
            });
            this.map.addControl(this.sidebar);
            this.map.addControl(L.control.drawLine({
                sidebar: this.sidebar,
                calcData: this.calcData,
                featureHandler: this.handleFeature()
            }));

//            this.handleZoomChange({map: this.map, oData: this.overlayData, oImage: oImage})
//            this.handleZoomChange({map: this.map, oData: this.overlayData});
//            this.handleDrawControlEvents(this.map)
        },
        handleFeature() {
//            alert('handleFeature')
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
