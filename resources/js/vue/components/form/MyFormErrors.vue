<template>
    <p class="error text-red-500 text-xs italic">
        {{ message }}
    </p>
</template>

<script>
export default {
    name: "MyFormErrors",
    props: ['errors', 'name'],
    data() {
        return {
            message: this.errors && this.errors[this.name] ? this.errors[this.name].message : null,
        }
    }
}
</script>

<style scoped>
</style>
