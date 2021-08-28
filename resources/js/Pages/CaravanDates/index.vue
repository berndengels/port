<template>
    <AppLayout title="Wohnwagen Dates">
        <nav-link :href="create_url" class="ml-2 my-2">
            Neueintrag
        </nav-link>

        <table v-if="data && data.length > 0" class="table">
            <tr>
                <th>Kennzeichen</th>
                <th>Länge</th>
                <th>Von</th>
                <th>Bis</th>
                <th>Tage</th>
                <th>Preis €</th>
                <th colspan="2"></th>
            </tr>
            <tr v-for="item in data" :key="item.id">
                <td><NavLink :href="item.show_url">{{ item.carnumber }}</NavLink></td>
                <td>{{ item.carlength }}</td>
                <td>{{ formatDate(item.from) }}</td>
                <td>{{ formatDate(item.until) }}</td>
                <td>{{ item.days }}</td>
                <td>{{ item.price }}</td>
                <td><NavLink :href="item.edit_url">Edit</NavLink></td>
                <td><Button @click="remove(item)">Löschen</Button></td>
            </tr>
            <tr>
                <th>Preis Tota €:</th>
                <td colspan="8">{{ priceTotel }}</td>
            </tr>
        </table>
        <h3 v-else>Keine Daten vorhanden</h3>
    </AppLayout>
</template>

<script>
import ResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'
import { Inertia } from '@inertiajs/inertia'
import Button from "../../Jetstream/Button";
import NavLink from "../../Jetstream/NavLink";
import AppLayout from "../../Layouts/AppLayout";
import DateFormat from "../../Mixins/DateFormat";

export default {
    name: "index",
    components: {
        AppLayout,
        NavLink,
        Button,
        ResponsiveNavLink,
    },
    mixins: [DateFormat],
    props: {
        data: Array,
        create_url: String,
    },
    data() {
        return {
            selected: null
        }
    },
    computed: {
        priceTotel() {
            var total = 0;
            for(let i of this.data) {
                total += i.price
            }
            return total
        }
    },
    methods: {
        onSelect(item) {
            this.selected = item
        },
        remove(item) {
            if(confirm('Datensatz (ID: ' + item.id + ') wirklich löschen?')) {
                Inertia.delete('caravanDates/' + item.id, item)
            }
        }
    }
}
</script>

<style scoped>
</style>
