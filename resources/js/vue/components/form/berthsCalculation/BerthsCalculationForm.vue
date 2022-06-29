<template>
    <div class="m-5">
        <form
            :id="id"
            :data="data"
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
    props: ['id', 'data', 'errors', 'css'],
}
</script>

<style scoped>
</style>
