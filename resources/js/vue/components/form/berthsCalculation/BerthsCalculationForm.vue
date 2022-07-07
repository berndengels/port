<template>
    <div class="m-5">
        <form
            :id="id"
            :data="data"
            :docksOptions="docksOptions"
            :class="css"
            :errors="errors"
        >
            <slot></slot>
        </form>
    </div>
</template>

<script>
export default {
    name: "BerthsCalculationForm",
    props: ['id', 'data', 'docksOptions', 'errors', 'css'],
}
</script>

<style scoped>
</style>
