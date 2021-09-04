<template>
    <DefaultLayout title="Wohnwagen">
        <MyLink :href="create_url" icon="far fa-plus-square" ctrClass="ml-2 my-2 no-hide-text" title="neuen Caravan eintragen">
            Neueintrag
        </MyLink>

        <MyForm v-if="data.length > 0" :data="filter" css="flex-inline" @submit.prevent>
            <SelectFilter name="caravan" label="Kennzeichen" keyName="id" field="carnumber"
                  :options="data"
                  @selectedCaravan="onSelectCaravan"
            />
            <Button @click="reset" css="inline w-1/6 ml-3" btnCss="btn btn-second">Reset</Button>
        </MyForm>

        <div v-if="caravans.length > 0">
            <h5>{{ count }} Einträge</h5>
            <table class="table w-full">
                <tr>
                    <th>Kennzeichen</th>
                    <th>Länge</th>
                    <th>Email</th>
                    <th colspan="2"><br></th>
                </tr>
                <tr v-for="item in caravans" :key="item.id">
                    <td class="has-tooltip">
                        <span  @dblclick="ondblclick(item)" class="carnumber cursor-pointer">{{ item.carnumber }}</span>
                    </td>
                    <td>{{ item.carlength }} m</td>
                    <td><a v-if="item.email" :href="'mailto:' + item.email" target="_blank">{{ item.email }}</a><br v-else></td>
                    <td>
                        <MyLink :href="route('caravans.edit', item)" icon="fas fa-edit" ctrClass="btn" title="Bearbeiten">
                            Edit
                        </MyLink>
                    </td>
                    <td>
                        <MyLink role="button" @click="remove(item)" icon="fas fa-trash-alt" ctrClass="btn-red" title="Löschen">
                            Löschen
                        </MyLink>
                    </td>
                </tr>
            </table>
            <!--Pagination class="mt-6" :links="data.links" /-->
        </div>
        <h3 v-else>Keine Daten vorhanden</h3>
    </DefaultLayout>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
import Button from "../../Components/Form/Button";
import NavLink from "../../Jetstream/NavLink";
import DefaultLayout from "../../Layouts/DefaultLayout";
import SelectFilter from "../../Components/Form/SelectFilter";
import MyForm from "../../Components/Form/MyForm";
import Pagination from "../../Components/Pagination";
import MyLink from "../../Components/Form/MyLink";
import MyString from "../../Mixins/MyString";

export default {
    name: "index",
    components: {
        MyLink,
        MyString,
        Pagination,
        MyForm,
        SelectFilter,
        DefaultLayout,
        NavLink,
        Button,
    },
    mixins: [MyString],
    props: {
        data: Object,
        create_url: String,
    },
    data() {
        return {
            caravans: this.data ?? [],
            selectedCaravan: null,
            filter: this.$inertia.form({
                caravan: null,
            }),
        }
    },
    computed: {
        count() {
            return this.caravans.length
        }
    },
    methods: {
        reset() {
            this.caravans = this.data
            this.filter.reset()
        },
        onSelectCaravan(id) {
            this.selectedCaravan = ("" !== id) ? parseInt(id) : null;
            if(this.selectedCaravan) {
                this.caravans = this.data.filter(item => {
                    if(item.id == this.selectedCaravan) {
                        return item
                    }
                });
            }
        },
        remove(item) {
            if(confirm('Datensatz (ID: ' + item.id + ') wirklich löschen?')) {
                Inertia.delete('caravans/' + item.id, item)
            }
        },
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
