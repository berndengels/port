<template>
    <AppLayout title="Wohnwagen">
        <nav-link :href="create_url" class="ml-2 my-2">
            neuen Wohnwagen eintragen
        </nav-link>

        <table v-if="data && data.length > 0">
            <tr v-for="item in data" :key="item.id">
                <td>{{ item.id }}</td>
                <td>{{ item.carnumber }}</td>
                <td>{{ item.carlength }}</td>
                <td><NavLink :href="item.edit_url">Edit</NavLink></td>
                <td><Button @click="remove(item)">Löschen</Button></td>
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

export default {
    name: "index",
    components: {
        AppLayout,
        NavLink,
        Button,
        ResponsiveNavLink,
    },
    props: {
        data: Array,
        create_url: String,
    },
    methods: {
        edit(item) {

        },
        remove(item) {
            if(confirm('Datensatz (ID: ' + item.id + ') wirklich löschen?')) {
                Inertia.delete('caravans/' + item.id, item)
            }
        }
    }

}
</script>

<style scoped>
</style>
