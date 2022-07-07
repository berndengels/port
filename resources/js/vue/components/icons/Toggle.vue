<template>
    <i :class="css" @click="toggle(item)"></i>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "Toggle",
    props: ['item', 'field'],
    data() {
        return {
            css: this.item.properties[this.field] ? "text-xl text-green-600 fas fa-check-circle on" : "text-xl text-red-600 fas fa-times off",
        }
    },
    computed: {
        ...mapGetters({
//            selected: "guestboatBerth/selected",
        }),
    },
    methods: {
        toggle(item) {
            let data = {
                type: item.type,
                geometry: item.geometry,
                properties: { ...item.properties, [this.field]: !item.properties[this.field] }
            };
            this.update(data);
            this.css = !item.properties[this.field] ? "text-xl text-green-600 fas fa-check-circle on" : "text-xl text-red-600 fas fa-times off"
        },
        ...mapActions({
            update: "guestboatBerth/update",
        }),
    }
}
</script>

<style scoped>
i {
    cursor: pointer;
}
</style>
