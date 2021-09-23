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
            <Button @click="reset" css="inline w-1/6 ml-3"
                    btnCss="btn btn-second"
                    icon="fas fa-undo-alt"
                    title="Alle Filter zurücksetzen"
            >Reset</Button>
        </MyForm>

        <div v-if="caravans.length > 0">
            <h5>{{ total }} Einträge</h5>
            <VueTailwindPagination
                class="paginator"
                v-if="total > perPage"
                :current="currentPage"
                :total="total"
                :per-page="perPage"
                text-before-input="gehe zu Seite"
                text-after-input="Los"
                @page-changed="onPageClick"
            />
            <table class="table w-full">
                <tr>
                    <th>Kennzeichen</th>
                    <th>Länge</th>
                    <th>Email</th>
                    <th colspan="2"><br></th>
                </tr>
                <tr v-for="item in paginated" :key="item.id">
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
import MyLink from "../../Components/Form/MyLink";
import MyString from "../../Mixins/MyString";
import MyPagination from "../../Mixins/MyPagination";
import '@ocrv/vue-tailwind-pagination/styles'
import VueTailwindPagination from '@ocrv/vue-tailwind-pagination'

export default {
    name: "index",
    components: {
        MyLink,
        MyString,
        VueTailwindPagination,
        MyForm,
        SelectFilter,
        DefaultLayout,
        NavLink,
        Button,
    },
    mixins: [MyString, MyPagination],
    props: {
        data: Object,
        create_url: String,
    },
    data() {
        return {
            currentPage: 1,
            perPage: 20,
            total: this.data.length,
            caravans: [],
            paginated: [],
            selectedCaravan: null,
            filter: this.$inertia.form({
                caravan: null,
            }),
        }
    },
    computed: {
        count() {
            return this.caravans.length
        },
    },
    created() {
        this.caravans = this.data
        this.paginated = this.chunks(this.data, this.perPage)[this.currentPage - 1]
    },
    methods: {
        setDataAndPages(data) {
            this.caravans = data
            if(data.length > this.perPage) {
                this.paginated = this.chunks(data, this.perPage)[this.currentPage - 1]
            } else {
                this.paginated = data
            }
        },
        onPageClick(currentPage){
            this.currentPage = currentPage
            let arr = this.chunks(this.data, this.perPage)
            if(this.currentPage <= arr.length) {
                this.paginated = arr[this.currentPage - 1]
            }
        },
        onSelectCaravan(id) {
            this.selectedCaravan = ("" !== id) ? parseInt(id) : null;
            if(this.selectedCaravan) {
                let data = this.data.filter(item => {
                    if(item.id == this.selectedCaravan) {
                        return item
                    }
                });
                this.setDataAndPages(data)
            }
        },
        reset() {
            this.filter.reset()
            this.filter.caravan = null
            this.currentPage = 0
            this.caravans = this.data
            this.paginated = this.chunks(this.data, this.perPage)[this.currentPage - 1]
        },
        remove(item) {
            if(confirm('Datensatz (ID: ' + item.id + ') wirklich löschen?')) {
                Inertia.delete(route('caravans.destroy', item), {
                    preserveScroll: true,
                    onSuccess: (resp) => {
                        let data = this.data.filter(i => i !== item)
                        this.setDataAndPages(data)
                    }
                })
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
