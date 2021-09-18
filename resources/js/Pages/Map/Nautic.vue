<template>
    <DefaultLayout title="Seekarte">
        <div class="h-full w-full" id="map"></div>
    </DefaultLayout>
</template>

<script>
import DefaultLayout from "../../Layouts/DefaultLayout";

export default {
    name: "Nautic",
    components: {DefaultLayout},
    data() {
        return {
            webapi: null,
            lat: 54.025155,
            lng: 13.913493,
            token: process.env.MIX_NAVIONICS_TOKEN,
        }
    },
    mounted() {
        this.showMap()
    },
    methods: {
        showMap() {
            this.webapi = new JNC.Views.BoatingNavionicsMap({
                tagId: '#map',
                center: [  this.lat, this.lng ],
                navKey: this.token
            });
        }
    }
}
</script>

<style scoped>
#map {
    width: 100%;
    height: 100%;
    min-width: 100%;
    min-height: ;
    background-color: #eee;
    border: 1px solid #ccc;
}
</style>
