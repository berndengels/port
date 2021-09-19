<template>
    <div :class="css" :id="id"></div>
</template>

<script>
require("leaflet/dist/leaflet")
require("leaflet-providers")

export default {
    name: "OpenSeeMap",
    props: {
        id: String,
        css: String,
        lat: Number,
        lng: Number,
        zoom: Number,
    },
    mounted() {
        this.showMap()
    },
    computed: {
        coord() {
            return [this.lat, this.lng]
        }
    },
    methods: {
        showMap() {
            var map = L.map(this.id).setView(this.coord, this.zoom),
                myIcon = new L.Icon({
                    iconUrl: '/images/icons8-maps-48.png',
                    iconSize:     [48, 48], // size of the icon
                    iconAnchor:   [24, 48], // point of the icon which will correspond to marker's location
                    popupAnchor:  [0, -24] // poi
                }),
                myMarker = new L.marker(this.coord, {icon: myIcon})
                    .addTo(map)
                    .bindPopup("<b>Yachtanlieger Achterwasser</b>").openPopup()
            ;
            L.tileLayer.provider('OpenStreetMap.DE').addTo(map)
            L.tileLayer.provider('OpenSeaMap').addTo(map);
        }
    },
}
</script>

<style scoped>
@import "~leaflet/dist/leaflet.css";
</style>
