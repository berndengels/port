<template>
    <div class="'md:flex md:items-center mb-6'" :class="css">
        <button
            :class="btnCss"
            class="rounded"
        ><slot /></button>
    </div>
</template>

<script>
export default {
    name: "Button",
    props: {
        css: String,
        btnCss: String,
    }
}
</script>

<style scoped>
</style>
