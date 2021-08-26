<template>
    <form class="w-full" :data="data">
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
    }
}
</script>

<style scoped>
</style>
