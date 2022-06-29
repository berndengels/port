<template>
    <div v-if="!loaded" class="loader-wrapper">
        <PulseLoader :color="loader.color" />
    </div>
    <div v-else class="flex-container-dashboard admin">
        <Weather :weather-data="weatherData" />
    </div>
</template>

<script type="module">
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import Weather from "v@/components/Weather";
import WeatherMixin from "v@/mixins/weather";

export default {
    name: "Dashboard",
    components: {PulseLoader, Weather},
    mixins: [WeatherMixin],
    data() {
        return {
            loader: {
                loading: false,
                color: '#394263',
                size: '40px',
            },
        }
    },
    computed: {
        loaded() {
            return !!weatherData;
        }
    }
}
</script>

<style scoped>
</style>
