<template>
    <div class="card">
        <div class="card-header"><strong v-html="title"></strong></div>
        <div v-if="!loading" class="card-body p-3">
            <h5  v-if="error[model]" class="text-danger" v-html="error[model]"></h5>
            <v-chart v-else-if="option.series" class="chart" :option="option" autoresize />
        </div>
        <div v-else class="card-body p-3 loader-wrapper">
            <pulse-loader />
        </div>
    </div>
</template>

<script>
import {use} from "echarts/core"
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import {CanvasRenderer} from "echarts/renderers"
import {BarChart, LineChart} from "echarts/charts"
import {
    TitleComponent,
    TooltipComponent,
    LegendComponent,
    ToolboxComponent,
    GridComponent
} from "echarts/components"
import VChart, {THEME_KEY} from "vue-echarts"
import {mapGetters} from "vuex";

use([
    CanvasRenderer,
    BarChart,
    TitleComponent,
    TooltipComponent,
    LegendComponent,
    ToolboxComponent,
    GridComponent,
])
export default {
    name: "SalesVolumeStats",
    components: {VChart, PulseLoader},
    props: ['title','apartmentEnabled','HouseEnabled','houseboatEnabled','model'],
    computed: {
        loading() { return this.$store.state.stats.loading },
        ...mapGetters({
            data: "stats/rentalSalesVolumes",
            error: "stats/error",
        })
    },
    data() {
        return {
            option: {
                legend: {
                    data: null,
                },
                dataZoom: {
                    type: "slider",
                    disable: false,
                },
                grid: {
                    top: '10%',
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis: {
                    type: 'category',
                    data: null,
                },
                yAxis: { type: 'value' },
                series: null,
            }
        }
    },
    mounted() {
        setTimeout(() => { this.setData() },2000);
    },
    methods: {
        setData() {
            if(this.data) {
                this.option.legend.data = this.data.legends;
                this.option.xAxis.data = this.data.dates;
                this.option.series = this.data.series;
            }
        }
    },
}
</script>
