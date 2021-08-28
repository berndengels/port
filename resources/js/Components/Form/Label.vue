<template>
    <div class="md:w-1/3">
        <label
            :for="myFor"
            class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
        >{{ text }}</label>
    </div>
</template>

<script>
export default {
    name: "Label",
    props: {
        text: String,
        myFor: String,
    },
}
</script>

<style scoped>
</style>
