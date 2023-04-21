<template>
    <div v-if="weatherData" class="card">
        <div class="card-header">
            <strong v-if="loading">warte auf Wetterdaten</strong>
            <strong v-else>Wetter für {{weatherData.Name}}</strong>
        </div>
        <div v-if="loading" class="card-body p-3 loader-wrapper">
            <pulse-loader />
        </div>
        <div v-else class="card-body p-3 weather">
            <div class="bild">
                <img class="bild" :src="weatherData.iconUrl"
                     width="50" height="50" :alt="weatherData.Beschreibung" />
            </div>
            <div class="beschreibung">
                <div v-html="weatherData.Beschreibung"></div>
            </div>
            <div class="temperatur">
                <div>Temperatur </div>
                <div v-html="weatherData.Temperatur"></div>
            </div>
            <div class="sonnenaufgang">
                <div>Sonnenaufgang </div>
                <div v-html="weatherData.Sonnenaufgang"></div>
            </div>
            <div class="sonnenuntergang">
                <div>Sonnenuntergang </div>
                <div v-html="weatherData.Sonnenuntergang"></div>
            </div>
            <div class="windrichtúng">
                <div>Windrichtúng </div>
                <div v-html="weatherData.Windrichtúng"></div>
            </div>
            <div class="windgeschwindigkeit">
                <div>Windgeschwindigkeit </div>
                <div v-html="weatherData.Windgeschwindigkeit"></div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

export default {
    name: "Weather",
    components: {PulseLoader},
    computed: {
        ...mapGetters ({
            weatherData: "weather/data",
            loading: "weather/loading",
        }),
    }
}
</script>

<style scoped>
</style>
