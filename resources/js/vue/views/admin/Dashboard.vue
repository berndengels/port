<template>
    <div v-if="!loaded" class="loader-wrapper">
        <PulseLoader />
    </div>
    <div v-else class="flex-container-dashboard admin">
        <Weather :weather-data="weatherData" />
        <CaravansToday v-if="caravansToday && caravansEnabled" :caravans="caravansToday" />
        <VisitsStats v-if="caravans && caravansEnabled" title="Caravan Besucher" :data="caravans" color="#ff025d" />
        <VisitsStats v-if="boats && boatsEnabled" title="Boots Termine" :data="boats" color="#377cff" />
        <VisitsStats v-if="guestBoats && boatsEnabled" title="Gastboot Besuche" :data="guestBoats" color="#03926e" />
        <HouseboatsCalendar v-if="houseboatDates && houseboatsEnabled" title="Hausboot Belegung" :dates="houseboatDates" color="#a3013e" />
    </div>
</template>

<script>
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import Weather from "../../components/Weather";
import WeatherMixin from "../../mixins/weather";
import VisitsStats from "../../components/VisitsStats";
import CaravansToday from "../../components/CaravansToday";
import HouseboatsCalendar from "v@/components/HouseboatsCalendar";
import { mapGetters } from "vuex";

export default {
    name: "Dashboard",
    components: {HouseboatsCalendar, CaravansToday, VisitsStats, PulseLoader, Weather},
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
        this.$store.dispatch("stats/get", "caravans");
        this.$store.dispatch("stats/get", "boats");
        this.$store.dispatch("stats/get", "guestBoats");
        this.$store.dispatch("houseboat/fetchDates");
        this.$store.dispatch("offers/fetch")
    },
    computed: {
        houseboatsEnabled() {
            return this.$store.state.offers.enabled.Hausboote;
        },
        boatsEnabled() {
            return this.$store.state.offers.enabled.Boote;
        },
        caravansEnabled() {
            return this.$store.state.offers.enabled.Caravans;
        },
        bootservicesEnabled() {
            return this.$store.state.offers.enabled.Bootsservice;
        },
        loaded() {
            return true;
        },
        ...mapGetters({
            caravansToday: "caravan/todayVisits",
            caravans: "stats/caravans",
            boats: "stats/boats",
            guestBoats: "stats/guestBoats",
            houseboatDates: "houseboat/dates",
        }),
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
