<template>
    <div v-if="!loaded" class="loader-wrapper">
        <PulseLoader :color="loader.color" />
    </div>
    <div v-else class="flex-container-dashboard admin">
        <Weather :weather-data="weatherData" />
        <VisitsStats v-if="caravansLoaded" title="Caravan Besucher" :data="caravans" color="#ff025d" />
        <VisitsStats v-if="boatsLoaded" title="Boots Termine" :data="boats" color="#377cff" />
        <VisitsStats v-if="guestBoatsLoaded" title="Gastboot Besuche" :data="guestBoats" color="#03926e" />
    </div>
</template>

<script>
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import Weather from "../components/Weather";
//import CaravanStats from "../components/CaravanStats";
import WeatherMixin from "../mixins/weather";
import VisitsStats from "../components/VisitsStats";

export default {
    name: "Dashboard",
    components: {VisitsStats, PulseLoader, Weather},
    mixins: [WeatherMixin],
    data() {
        return {
            minDataLimit: 10,
            caravansLoaded: false,
            boatsLoaded: false,
            guestBoatsLoaded: false,
            caravans: null,
            boats: null,
            guestBoats: null,
            loader: {
                loading: false,
                color: '#394263',
                size: '40px',
            },
        }
    },
    mounted() {
        this.getCaravans()
        this.getBoats()
        this.getGuestBoats()
    },
    methods: {
        getCaravans() {
            axios.get('api/stats/caravans')
                .then(resp => {
                    if(! resp.data || resp.data.length < this.minDataLimit) {
                        return false
                    }
                    this.caravans = resp.data
                    this.caravansLoaded = true
                })
                .catch(err => console.error(err))
        },
        getBoats() {
            axios.get('api/stats/boats')
                .then(resp => {
                    if(! resp.data || resp.data.length < this.minDataLimit) {
                        return false
                    }
                    this.boats = resp.data
                    this.boatsLoaded = true
                })
                .catch(err => console.error(err))
        },
        getGuestBoats() {
            axios.get('api/stats/guestBoats')
                .then(resp => {
                    if(! resp.data || resp.data.length < this.minDataLimit) {
                        return false
                    }
                    this.guestBoats = resp.data
                    this.guestBoatsLoaded = true
                })
                .catch(err => console.error(err))
        }
    },
    computed: {
        loaded() {
            return true;
/*
            return this.caravansLoaded
                && this.weatherDataLoaded
                && this.boatsLoaded
                && this.guestBoatsLoaded;
*/
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
