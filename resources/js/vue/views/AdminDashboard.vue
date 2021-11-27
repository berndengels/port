<template>
    <div v-if="!loaded" class="loader-wrapper">
        <PulseLoader :color="loader.color" />
    </div>
    <div v-else class="flex-container-dashboard admin">
        <Weather :weather-data="weatherData" />
        <CaravansToday v-if="caravansToday" :caravans="caravansToday" />
        <VisitsStats v-if="caravans" title="Caravan Besucher" :data="caravans" color="#ff025d" />
        <VisitsStats v-if="boats" title="Boots Termine" :data="boats" color="#377cff" />
        <VisitsStats v-if="guestBoats" title="Gastboot Besuche" :data="guestBoats" color="#03926e" />
    </div>
</template>

<script>
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import Weather from "../components/Weather";
import WeatherMixin from "../mixins/weather";
import VisitsStats from "../components/VisitsStats";
import CaravansToday from "../components/CaravansToday";
import {mapGetters} from "vuex";

export default {
    name: "AdminDashboard",
    components: {CaravansToday, VisitsStats, PulseLoader, Weather},
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
    created() {
        this.$store.dispatch("stats/get", "caravans")
        this.$store.dispatch("stats/get", "boats")
        this.$store.dispatch("stats/get", "guestBoats")
    },
    computed: {
        ...mapGetters({
            caravansToday: "caravan/todayVisits",
            caravans: "stats/caravans",
            boats: "stats/boats",
            guestBoats: "stats/guestBoats",
        }),
        loaded() {
            return true;
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
