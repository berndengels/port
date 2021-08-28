<template>
    <form class="block w-3/4 justify-center" :data="data">
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
