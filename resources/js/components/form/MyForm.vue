<template>
    <div class="m-5">
        <form :data="data" :store="myStore" :method="method" :action="action" @submit.prevent="store(data)">
            <slot></slot>
        </form>
    </div>
</template>

<script>
import { mapActions } from "vuex"

export default {
    name: "MyForm",
    props: ['data', 'method', 'action'],
    methods: {
        ...mapActions({store: "caravan/store"})
    },
}
</script>

<style scoped>
</style>
