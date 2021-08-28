<template>
    <div>

    </div>
</template>

<script>
export default {
    name: "CaravanPriceCalculation",
    props: ['prices'],
    computed: {
        priceData() {
            return JSON.parse(this.prices)
        }
    },
    created() {
        console.info(this.priceData)
    }
}
</script>

<style scoped>
</style>
