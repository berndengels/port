<template>
    <DefaultLayout :title="'Wohnmobil ' + caravanDate.caravan.carnumber">
        <MyLink :href="route('caravanDates.index')" icon="fas fa-backward">zurück</MyLink>
        <table class="table w-full">
            <tr>
                <th class="text-right">Kennzeichen</th>
                <td @dblclick="ondblclick(caravanDate.caravan)">{{ caravanDate.caravan.carnumber }}</td>
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
                <th class="text-right">Anzahl Übernachtungen</th>
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
import MyLink from "../../Components/Form/MyLink";

export default {
    name: "show",
    components: {MyLink, DefaultLayout, NavLink, CaravanPriceCalculation},
    props: ['caravanDate'],
    mixins: [DateFormat],
    methods: {
        ondblclick(caravan) {
            axios(route('car.info', caravan))
                .then(resp => {
                    if(resp.data.data && !resp.data.error) {
                        let info = resp.data.data;
                        alert(info.location + " (" + info.state + ")")
                    }
                })
                .catch(e=>console.error(e));
        },
    }
}
</script>

<style scoped>
</style>
