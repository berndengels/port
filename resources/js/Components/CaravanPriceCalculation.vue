<template>
    <div>
        <table class="table">
            <tr v-for="(price,date) in priceData" :key="date">
                <th class="top-0">{{ formatDate(date) }}</th>
                <td>
                    <table class="table">
                        <tr v-for="(item, key) in parsedPriceData(price)" :key="key">
                            <th class="text-right">{{ key }}</th>
                            <td>{{ item }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
import DateFormat from "../Mixins/DateFormat";
import PriceData from "../Mixins/PriceData";
export default {
    name: "CaravanPriceCalculation",
    props: ['prices'],
    mixins: [DateFormat,PriceData],
    computed: {
        priceData() {
            return JSON.parse(this.prices)
        }
    },
}
</script>

<style scoped>
</style>
