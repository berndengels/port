<template>
    <AppLayout :title="'Wohnmobil ' + caravanDate.caravan.carnumber">
        <NavLink :href="route('caravanDates.index')">zurück</NavLink>
        <table class="table">
            <tr>
                <th>Kennzeichen</th>
                <td>{{ caravanDate.caravan.carnumber }}</td>
            </tr>
            <tr>
                <th>Länge in Meter</th>
                <td>{{ caravanDate.caravan.carlength }}</td>
            </tr>
            <tr>
                <th>Personen</th>
                <td>{{ caravanDate.persons }}</td>
            </tr>
            <tr>
                <th>Strom-Anschluß</th>
                <td>{{ caravanDate.electric ? 'JA' : 'Nein'}}</td>
            </tr>
            <tr>
                <th>Von</th>
                <td>{{ formatDate(caravanDate.from) }}</td>
            </tr>
            <tr>
                <th>Bis</th>
                <td>{{ formatDate(caravanDate.until) }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <CaravanPriceCalculation :prices="caravanDate.prices" />
                </td>
            </tr>
        </table>
    </AppLayout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";
import CaravanPriceCalculation from "../../Components/CaravanPriceCalculation";
import NavLink from "../../Jetstream/NavLink";
import DateFormat from "../../Mixins/DateFormat";

export default {
    name: "show",
    components: {NavLink, CaravanPriceCalculation, AppLayout},
    props: ['caravanDate'],
    mixins: [DateFormat],
}
</script>

<style scoped>
</style>
