<template>
    <div class="mt-5">
        <br>
        <table class="table w-full mt-5">
            <tr>
                <th class="hidden md:table-cell">ID</th>
                <th>Steg</th>
                <th>Nummer</th>
                <th class="hidden md:table-cell">Länge</th>
                <th class="hidden md:table-cell">Breite</th>
                <th>Tagespreis</th>
                <th>Aktiv</th>
                <th colspan="2"><br></th>
            </tr>
            <tr v-for="item in data" :key="item.id">
                <td class="hidden md:table-cell">{{ item.id }}</td>
                <td class="hidden md:table-cell">{{ item.dock ? item.dock.name : '' }}</td>
                <td ><a href="#" @click.prevent="selectItem(item)">{{ item.number }}</a></td>
                <td class="hidden md:table-cell">{{ item.length }} m</td>
                <td class="hidden md:table-cell">{{ item.width }} m</td>
                <td>{{ item.daily_price ? item.daily_price + " €" : "" }}</td>
                <td><Toggle :item="item" field="enabled" /></td>
                <td>
                    <MyButton class="btn btn-save" @click.prevent="selectItem(item)">
                        <i class="fas fa-edit"></i>
                        <span class="hidden md:visible ml-1">Edit</span>
                    </MyButton>
                </td>
                <td>
                    <MyButton class="btn btn-red" @click="destroy(item)">
                        <i class="fas fa-trash-alt"></i>
                        <span class="hidden md:visible ml-1">Delete</span>
                    </MyButton>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
import {mapActions} from "vuex";
import Toggle from "v@/components/icons/Toggle";

export default {
    name: "Table",
    components: {Toggle},
    props: ['data'],
    methods: {
        selectItem(item) {
            this.select(item);
            this.$emit('showEditForm', true)
        },
        ...mapActions({
            destroy: "guestboatBerth/detroy",
            select: "guestboatBerth/select",
        }),
    }
}
</script>

<style scoped>
</style>
