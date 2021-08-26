<template>
    <div class="block my-2">
        <div class="md:w-1/3"></div>
        <div class="md:w-2/3">
            <button
                :type="type"
                :class="css"
                class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded"
            >{{ label }}</button>
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
