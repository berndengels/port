<template>
    <div class="container w-100">
        <RentalsCalendar title="Vermietung" only-from-today />
    </div>
</template>

<script>
import RentalsCalendar from "v@/components/RentalsCalendar.vue";
import {useStore} from "vuex";

export default {
    name: "BookingCalendar",
    components: {RentalsCalendar},
    setup() {
        const store = useStore()
        store.dispatch("rentals/fetchReservations")
        store.dispatch("offers/fetch")
    },
}
</script>

<style scoped>
</style>
