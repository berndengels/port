<template>
    <div class="md:flex md:items-center mb-6">
        <div class="md:w-1/3"></div>
        <div class="md:w-2/3">
            <button
                id="btn"
                :type="type"
                :class="css"
                class="rounded"
            ><slot /></button>
        </div>
    </div>
</template>

<script>
export default {
    name: "Button",
    props: {
        name: String,
        label: String,
        css: String,
        type: {
            type: String,
            default: 'button',
        }
    }
}
</script>

<style scoped>
</style>
