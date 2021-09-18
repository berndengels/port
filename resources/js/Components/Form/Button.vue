<template>
    <div class="'md:flex md:items-center mb-6'" :class="css">
        <button
            :class="btnCss"
            class="rounded"
        ><i v-if="icon" :class="icon"></i><slot /></button>
    </div>
</template>

<script>
export default {
    name: "Button",
    props: {
        css: String,
        btnCss: String,
        icon: String,
    }
}
</script>

<style scoped>
</style>
