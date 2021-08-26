<template>
    <div>
        <Head title="Wohnwagen"/>

        <nav-link :href="create_url" class="ml-2 my-2">
            Neueintrag
        </nav-link>

        <table v-if="data && data.length > 0">
            <tr v-for="item in data" :key="item.id">
                <td>{{ item.carnumber }}</td>
                <td>{{ item.carlength }}</td>
                <td>{{ item.from }}</td>
                <td>{{ item.until }}</td>
                <td>{{ item.price }}</td>
                <td><NavLink :href="item.edit_url">Edit</NavLink></td>
                <td><Button @click="remove(item)">Löschen</Button></td>
            </tr>
        </table>
        <h3 v-else>Keine Daten vorhanden</h3>
    </div>
</template>

<script>
import ResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'
import { Inertia } from '@inertiajs/inertia'
import Button from "../../Jetstream/Button";
import NavLink from "../../Jetstream/NavLink";

export default {
    name: "index",
    components: {
        NavLink,
        Button,
        ResponsiveNavLink,
    },
    props: {
        data: Array,
        create_url: String,
    },
    methods: {
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
