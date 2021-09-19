<template>
    <div :class="css" :id="id"></div>
</template>

<script>
export default {
    name: "Navionics",
    props: {
        id: String,
        css: String,
        lat: Number,
        lng: Number,
        zoom: Number,
        accessToken: String,
    },
    data() {
        return {
            webapi: null,
        }
    },
    created() {
    },
    beforeMount() {
        this.addCss()
        this.addScript()
    },
    mounted() {
        this.showMap()
    },
    methods: {
        addCss() {
            let tag = document.createElement('link')
            tag.setAttribute('rel','stylesheet')
            tag.href = 'https://webapiv2.navionics.com/dist/webapi/webapi.min.css'
            document.head.appendChild(tag);
        },
        addScript() {
            let tag = document.createElement('script')
            tag.setAttribute('type','text/javascript')
            tag.src = 'https://webapiv2.navionics.com/dist/webapi/webapi.min.no-dep.js'
            document.head.appendChild(tag);
        },
        showMap() {
            this.webapi = new JNC.Views.BoatingNavionicsMap({
                tagId: '#' + this.id,
                center: [  this.lat, this.lng ],
                navKey: this.accessToken
            });
        }
    }
}
</script>

<style scoped>
</style>
