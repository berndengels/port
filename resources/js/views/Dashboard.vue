<template>
    <div v-if="!loaded" class="loader-wrapper">
        <PulseLoader :color="loader.color" />
    </div>
    <div v-else class="flex-container-dashboard admin">
        <Weather :weather-data="weatherData" />
        <CaravanStats v-if="caravansLoaded" :caravans="caravans" :loaded="caravansLoaded" />
    </div>
</template>

<script>
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import Weather from "../components/Weather";
import CaravanStats from "../components/CaravanStats";
import WeatherMixin from "../mixins/weather";

export default {
    name: "Dashboard",
    components: {PulseLoader, CaravanStats, Weather},
    mixins: [WeatherMixin],
    data() {
        return {
            caravansLoaded: false,
            caravans: null,
            loader: {
                loading: false,
                color: '#394263',
                size: '40px',
            },
        }
    },
    mounted() {
        this.getCaravans()
    },
    methods: {
        getCaravans() {
            axios.get('api/caravan/stats')
                .then(resp => {
                    if(! resp.data) {
                        return false
                    }
                    this.caravans = resp.data
                    this.caravansLoaded = true
                })
                .catch(err => console.error(err))
        }
    },
    computed: {
        loaded() {
            return this.caravansLoaded && this.weatherDataLoaded
        }
    }
}
</script>

<style scoped>
.loader-wrapper {
    width: 100%;
    height: 100vh;
    text-align: center;
    background-color: #aaa;
    opacity: 0.3;
}

.loader-wrapper .v-spinner {
    position: absolute;
    display: inline-block;
    margin-top: 100px;
}
</style>
