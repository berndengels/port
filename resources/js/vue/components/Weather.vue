<template>
    <div v-if="weatherData" class="flex-item-dashboard p-3 widget">
        <div class="title weatherTitle">Wetter für {{weatherData.Name}}</div>
        <div class="content mt-2 weather">
            <div class="bild">
                <img class="bild" :src="weatherData.iconUrl" />
            </div>
            <div class="beschreibung">
                <div>{{ weatherData.Beschreibung }}</div>
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
export default {
    name: "Weather",
    props: ['weatherData'],
}
</script>

<style scoped>
</style>
