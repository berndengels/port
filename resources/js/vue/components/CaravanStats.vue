<template>
    <div class="flex-item-dashboard p-3 widget">
        <div class="content mt-2">
            <v-chart class="chart" :option="option" />
        </div>
    </div>
</template>

<script>
import {use} from "echarts/core";
import {CanvasRenderer} from "echarts/renderers";
import {LineChart} from "echarts/charts";
import {
    TitleComponent,
    TooltipComponent,
    LegendComponent,
    ToolboxComponent,
    GridComponent,
    DataZoomComponent
} from "echarts/components";
import VChart, {THEME_KEY} from "vue-echarts";
import {ref} from "vue";

use([
    CanvasRenderer,
    LineChart,
    TitleComponent,
    TooltipComponent,
    LegendComponent,
    ToolboxComponent,
    GridComponent,
    DataZoomComponent,
]);
export default {
    name: "CaravanStats",
    components: {VChart},
    props: ['caravans'],

    setup(props) {
        const option = ref({
            title: {
                text: "Caravan Besucher",
                textStyle: {
                    color: "#6574cd",
                }
            },
            tooltip: {
                trigger: 'axis',
//                formatter: "{b}<br/>{a}: {c0}"
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
//                top: '10%',
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
                data: props.caravans.map(i => i.from),
            },
            yAxis: {
                type: 'value',
                boundaryGap: false,
//                boundaryGap: [0, '100%'],
                splitLine: {
                    show: false
                }
            },
            series: [
                {
                    name: 'Besucher',
                    type: 'line',
                    stack: 'Total',
                    data: props.caravans.map(i => i.count)
                },
            ]
        });

        return { option };
    },
}
</script>

<style scoped>
</style>
