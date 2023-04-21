<template>
    <div class="card">
        <div class="card-header"><strong v-html="title"></strong></div>
        <div v-if="!loading" class="card-body p-3">
            <h5 v-if="error[model]" class="text-danger" v-html="error"></h5>
            <v-chart v-else-if="option.series[0].data.length > 0" class="chart" :option="option" autoresize />
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
import {LineChart} from "echarts/charts"
import {
    TitleComponent,
    TooltipComponent,
    LegendComponent,
    ToolboxComponent,
    GridComponent,
    DataZoomComponent
} from "echarts/components"
import VChart, {THEME_KEY} from "vue-echarts"

use([
    CanvasRenderer,
    LineChart,
    TitleComponent,
    TooltipComponent,
    LegendComponent,
    ToolboxComponent,
    GridComponent,
    DataZoomComponent,
])
export default {
    name: "VisitsStats",
    components: {VChart, PulseLoader},
    props: ['data','title','color','model'],
    setup(props) {
        const option = {
            title: {
                show: false,
            },
            tooltip: {
                trigger: 'axis',
            },
            dataZoom: {
                type: "slider",
                disable: false,
            },
            legend: {
                type: "scroll",
                orient: "vertical",
                z: 4,
                top: "10%",
                left: "left",
                data: ["Besucher"]
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'category',
                splitLine: {
                    show: false
                },
                boundaryGap: false,
                data: props.data.map(i => i.from),
            },
            yAxis: {
                type: 'value',
                boundaryGap: false,
                splitLine: {
                    show: false
                }
            },
            series: [
                {
                    name: 'Besucher',
                    type: 'line',
                    stack: 'Total',
                    data: props.data.map(i => i.count),
                    lineStyle: {
                        color: props.color ?? "blue",
                    },
                },
            ]
        };
        return {option};
    },
    computed: {
        loading() { return this.$store.state.stats.loading },
        error() { return this.$store.state.stats.error }
    },
}
</script>
