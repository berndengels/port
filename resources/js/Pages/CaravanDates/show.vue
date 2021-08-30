<template>
    <DefaultLayout :title="'Wohnmobil ' + caravanDate.caravan.carnumber">
        <NavLink :href="route('caravanDates.index')">zurück</NavLink>
        <table class="table w-full">
            <tr>
                <th class="text-right">Kennzeichen</th>
                <td>{{ caravanDate.caravan.carnumber }}</td>
            </tr>
            <tr>
                <th class="text-right">Wagenlänge</th>
                <td>{{ caravanDate.caravan.carlength }} m</td>
            </tr>
            <tr>
                <th class="text-right">Personen</th>
                <td>{{ caravanDate.persons }}</td>
            </tr>
            <tr>
                <th class="text-right">Strom-Anschluß</th>
                <td>{{ caravanDate.electric ? 'JA' : 'Nein'}}</td>
            </tr>
            <tr>
                <th class="text-right">Von</th>
                <td>{{ formatDate(caravanDate.from) }}</td>
            </tr>
            <tr>
                <th class="text-right">Bis</th>
                <td>{{ formatDate(caravanDate.until) }}</td>
            </tr>
            <tr>
                <th class="text-right">Anzahl Tage</th>
                <td>{{ countDays( caravanDate.from, caravanDate.until) }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <CaravanPriceCalculation :prices="caravanDate.prices" />
                </td>
            </tr>
        </table>
    </DefaultLayout>
</template>

<script>
import CaravanPriceCalculation from "../../Components/CaravanPriceCalculation";
import NavLink from "../../Jetstream/NavLink";
import DateFormat from "../../Mixins/DateFormat";
import DefaultLayout from "../../Layouts/DefaultLayout";

export default {
    name: "show",
    components: {DefaultLayout, NavLink, CaravanPriceCalculation},
    props: ['caravanDate'],
    mixins: [DateFormat],
}
</script>

<style scoped>
</style>
