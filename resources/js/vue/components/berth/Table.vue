<template>
    <div class="mt-1">
        <form>
            <button type="button" class="btn btn-danger" @click.prevent="deleteSelectedItems">ausgewähle löschen</button>
        </form>
        <p v-if="data" class="m-0 p-0 mt-2">Anzahl Liegeplätze {{ countBerths }} insgesamt</p>
        <table v-if="data" class="table table-striped table-sm mt-1">
            <thead>
                <tr>
                    <!--th scope="col" class="d-sm-none d-md-table-cell">ID</th-->
                    <th scope="col"></th>
                    <th scope="col" class="d-none d-md-table-cell">Steg</th>
                    <th scope="col">Nummer</th>
                    <th scope="col" class="d-none d-md-table-cell">Länge</th>
                    <th scope="col" class="d-none d-md-table-cell">Breite</th>
                    <th scope="col">Tagespreis</th>
                    <th scope="col">Aktiv</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in data" :key="item.id">
                    <!--td scope="row" class="d-sm-none d-md-table-cell">{{ item.id }}</td-->
                    <td><input type="checkbox" class="check form-checkbox" :value="item.id" /></td>
                    <td class="d-none d-md-table-cell">{{ item.dock ? item.dock.name : '' }}</td>
                    <td ><a href="#" class="text-decoration-none" @click.prevent="selectItem(item)">{{ item.number }}</a></td>
                    <td class="d-none d-md-table-cell">{{ item.length }} m</td>
                    <td class="d-none d-md-table-cell">{{ item.width }} m</td>
                    <td>{{ item.daily_price ? item.daily_price + " €" : "" }}</td>
                    <td><Toggle :item="item" field="enabled" /></td>
                    <td class="align-items-end p-0">
                        <form class="float-end">
                            <button type="button" class="btn btn-primary btn-sm" @click.prevent="selectItem(item)">
                                <i class="fas fa-edit"></i>
                                <span class="d-none d-md-inline ms-1">Edit</span>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm ms-2" @click.prevent="deleteItem(item)">
                                <i class="fas fa-trash-alt"></i>
                                <span class="d-none d-md-inline ms-1">Delete</span>
                            </button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
        <h3 v-else>Keine Daten vorhanden</h3>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import Toggle from "v@/components/icons/Toggle";
import MyButton from "v@/components/form/MyButton";

export default {
    name: "Table",
    components: {Toggle, MyButton},
    computed: {
        ...mapGetters({
            data: "berth/data",
        }),
        countBerths() {
            return this.data ? this.data.length : 0;
        }
    },
    methods: {
        deleteItem(item) {
            if(confirm('Datensatz wirklich löschen')) {
                this.destroy(item);
                return true
            }
            return false;
        },
        deleteSelectedItems() {
            var selected = [];
            $('table .check:checked').each((i, el) => {
                selected.push(el.value);
            });
            if(confirm("Alle " + selected.length + " Daten wirklich löschen?")) {
                this.destroyAny(selected);
            }
            return false;
        },
        selectItem(item) {
            this.select(item);
//            this.$emit('showEditForm', true)
        },
        ...mapActions({
            destroy: "berth/detroy",
            select: "berth/select",
            destroyAny: "berth/detroyAny",
        }),
    }
}
</script>

<style scoped>
</style>
