<template>
    <DefaultLayout title="Seekarte">
        <!--Navionics
            id="map"
            css="h-full w-full map"
            :lat="lat"
            :lng="lng"
            :access-token="token"
        /-->
        <OpenSeeMap
            id="map"
            css="map"
            :lat="lat"
            :lng="lng"
            :zoom="zoom"
        />
    </DefaultLayout>
</template>

<script>
import DefaultLayout from "../../Layouts/DefaultLayout";
import Navionics from "../../Components/Map/Navionics";
import OpenSeeMap from "../../Components/Map/OpenSeeMap";

export default {
    name: "Nautic",
    components: {OpenSeeMap, Navionics, DefaultLayout},
    data() {
        return {
            lat: 54.026379,
            lng: 13.910093,
            zoom: 14,
            token: process.env.MIX_NAVIONICS_TOKEN,
        }
    }
}
</script>

<style scoped>
</style>
