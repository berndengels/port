<template>
    <div class="m-5">
        <form
            :id="id"
            :data="data"
            :class="css"
            :errors="errors"
            @submit.prevent="save">
            <slot></slot>
        </form>
    </div>
</template>

<script>
export default {
    name: "MyBerthForm",
    props: ['id', 'data', 'errors', 'css'],
    methods: {
        save() {
        }
    },
}
</script>

<style scoped>
</style>
