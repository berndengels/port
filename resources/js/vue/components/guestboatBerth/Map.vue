<template>
    <div>
        <div id="mapBerths"></div>
        <FormCalculateBerths
            v-show="showCalcForm"
            @closeCalcForm="closeCalcForm"
        />
        <div class="m-5">
            <MyButton inline="true">update all</MyButton>
            <MyButton inline="true">remove all</MyButton>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import MyButton from "v@/components/form/MyButton";
import BerthsMapCalculationMixin from "v@/mixins/berthsMapCalculation";
import FormCalculateBerths from "v@/components/guestboatBerth/FormCalculateBerths";

export default {
    name: "Map",
    components: {FormCalculateBerths, MyButton},
    mixins: [BerthsMapCalculationMixin],
    props: ['id', 'data'],
    data() {
        return {
            id: this.id,
            map: null,
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
            calcData: "guestboatBerth/calcData",
            selected: "guestboatBerth/selected",
        }),
    },
    watch() {

    },
    methods: {
        initMap() {
            this.map = this.getMap();
            const drawControl = this.getDrawControl();
            this.map.addControl(drawControl);
/*
            const oImage = this.imageOverlay()
            if(oImage) {
                oImage.addTo(this.map);
            }
*/
            this.overlayData = this.getDataOverlay(this.data);
            if(this.overlayData) {
                this.overlayData.addTo(this.map)
            }

//            this.handleZoomChange({map: this.map, oData: this.overlayData, oImage: oImage})
            this.handleZoomChange({map: this.map, oData: this.overlayData});
            this.handleDrawControlEvents(this.map)
        },
        handleDrawControlEvents(map) {
            map.on('draw:drawstart', () => {
                this.showCalcForm = true
            });
            map.on('draw:created', ({layer}) => {
                const pointStart = layer.getLatLngs()[0],
                    pointEnd = layer.getLatLngs()[1],
                    params = {
                        ...this.calcData,
                        latLng1: pointStart,
                        latLng2: pointEnd,
                    };
                let data = this.findEquidistantPoints(params);

                data.forEach(el => this.addData(el));
                this.refill(data);
                this.showCalcForm = false
            });
        },
        closeCalcForm() {
            this.showCalcForm = false
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
