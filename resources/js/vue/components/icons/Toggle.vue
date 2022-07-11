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
            css: this.item[this.field] ? "text-xl text-green-600 fas fa-check-circle on" : "text-xl text-red-600 fas fa-times off",
        }
    },
    methods: {
        toggle(item) {
            let data = { ...item, [this.field]: !item[this.field] };
            this.update(data);
            this.css = !item[this.field] ? "text-xl text-green-600 fas fa-check-circle on" : "text-xl text-red-600 fas fa-times off"
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
