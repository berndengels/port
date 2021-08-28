<template>
    <form :class="css" :data="data">
        <slot />
    </form>
</template>

<script>
export default {
    name: "MyForm",
    props: {
        data: {
            type: Object,
            default: null,
        },
        css: {
            type: String,
            default: "block w-3/4 justify-center",
        },
    }
}
</script>

<style scoped>
</style>
