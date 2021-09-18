<template>
    <DefaultLayout title="Wohnwagen Rezeption">
        <div class="w-full clear-both">
            <div class="float-left">
                <MyLink :href="create_url"
                        icon="far fa-plus-square"
                        ctrClass="ml-2 my-2 no-hide-text"
                        title="neue Caravan Ankunft eintragen">
                    Neueintrag
                </MyLink>
            </div>
            <div v-if="caravanDates.length > 0" class="float-right">
                <MyLink :href="'/caravan/price/excel/' + currentFrom"
                        icon="far fa-file-excel"
                        ctrClass="ml-2 my-2 no-hide-text"
                        no-inertia="true"
                        target="_blank"
                        title="neue Caravan Ankunft eintragen">
                    Excel Download
                </MyLink>
                <MyForm v-if="caravanDates.length > 0" :data="frmSendExcel" css="flex-inline" @submit.prevent>
                    <Input type="email" name="email" v-model="frmSendExcel.email" required="true" placeholder="Email-Adresse" />
                    <Button @click="sendExcel" btnCss="btn btn-second" icon="fas fa-shipping-fast">Sende Excel</Button>
                </MyForm>
            </div>
        </div>
        <div class="w-full clear-both">
            <MyForm :data="frmFilter" css="flex-inline" @submit.prevent>
                <SelectFilter name="caravan" label="Kennzeichen" keyName="id" field="carnumber"
                              :withEmpty="true"
                              :options="caravans"
                              @selectedCaravan="onSelectCaravan"
                />
                <SelectFilter name="dublicate" label="Dublikate"
                              v-if="dublicates.length > 0"
                              :withEmpty="true"
                              :options="dublicates"
                              @selectedDublicate="onSelectDublicate"
                />
                <SelectYear v-if="years && years.length > 0" name="year" label="Jahr" :options="years" :default="selectedYear"
                            @selectYear="onSelectYear"
                />
                <SelectMonth v-if="selectedYear && months !== undefined && months.length > 0" name="month" label="Monat" :options="months"
                             @selectMonth="onSelectMonth"
                             css="ml-3"
                />
                <Button v-if="caravans.length > 0 || years.length > 0 || months !== undefined"
                        @click="reset"
                        css="inline w-1/6 ml-3"
                        btnCss="btn btn-second btn-reset"
                        icon="fas fa-undo-alt"
                        title="Alle Filter zurücksetzen"
                >Reset</Button>
            </MyForm>
        </div>
        <h5>{{ total }} Einträge</h5>
        <VueTailwindPagination
            v-if="total > perPage"
            :current="currentPage"
            :total="total"
            :per-page="perPage"
            @page-changed="onPageClick"
            text-before-input="gehe zu Seite"
            text-after-input="Los"
        />
        <table v-if="caravanDates.length > 0" class="table w-full">
            <tr>
                <th>Kennzeichen</th>
                <th>Länge</th>
                <th>Von</th>
                <th>Bis</th>
                <th>Tage</th>
                <th>Preis €</th>
                <th colspan="2"></th>
            </tr>
            <tr v-for="item in paginated" :key="item.id">
                <td><NavLink :href="item.show_url" class="carnumber">{{ item.carnumber }}</NavLink></td>
                <td>{{ item.carlength }} m</td>
                <td>{{ formatDate(item.from) }}</td>
                <td>{{ formatDate(item.until) }}</td>
                <td>{{ item.days }}</td>
                <td>{{ item.price }}</td>
                <td>
                    <MyLink :href="route('caravanDates.edit', item)" icon="fas fa-edit" ctrClass="btn" title="Bearbeiten">
                        Edit
                    </MyLink>
                </td>
                <td>
                    <MyLink role="button" @click="remove(item)" icon="fas fa-trash-alt" ctrClass="btn-red" title="Löschen">
                        Löschen
                    </MyLink>
                </td>
            </tr>
            <tr>
                <th class="text-red-500">Summe Einnahmen</th>
                <th colspan="8" class="text-left text-red-500">{{ priceTotel }} €</th>
            </tr>
        </table>
        <h3 v-else>Keine Daten vorhanden</h3>
    </DefaultLayout>
</template>

<script>
import ResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'
import { Inertia } from '@inertiajs/inertia'
import Button from "../../Components/Form/Button";
import NavLink from "../../Jetstream/NavLink";
import DateFormat from "../../Mixins/DateFormat";
import DefaultLayout from "../../Layouts/DefaultLayout";
import MyForm from "../../Components/Form/MyForm";
import SelectYear from "../../Components/Form/SelectYear";
import SelectMonth from "../../Components/Form/SelectMonth";
import SelectFilter from "../../Components/Form/SelectFilter";
import MyLink from "../../Components/Form/MyLink";
import Input from "../../Jetstream/Input";
import axios from "axios";
import MyPagination from "../../Mixins/MyPagination";
import '@ocrv/vue-tailwind-pagination/styles'
import VueTailwindPagination from '@ocrv/vue-tailwind-pagination'

const currentYear = dayjs().year(),
    currentMonth = dayjs().month() + 1;

export default {
    name: "index",
    components: {
        Input,
        MyLink,
        SelectFilter,
        SelectYear,
        SelectMonth,
        MyForm,
        DefaultLayout,
        NavLink,
        Button,
        ResponsiveNavLink,
        VueTailwindPagination,
    },
    mixins: [DateFormat, MyPagination],
    props: {
        caravans: Array,
        years: Array,
        monthsByYear: Array,
        create_url: String,
    },
    data() {
        return {
            currentPage: 1,
            perPage: 20,
            paginated: [],
            caravanDates: this.$page.props.caravan.dates.list,
            selected: null,
            selectedYear: null,
            selectedMonth: null,
            selectedCaravan: null,
            selectedDublicate: null,
            frmFilter: this.$inertia.form({
                year: null,
                month: null,
                caravan: null,
                dublicate: null,
            }),
            frmSendExcel: this.$inertia.form({
                email: null,
                from: null,
            }),
        }
    },
    created() {
        this.paginated = this.chunks(this.$page.props.caravan.dates.list, this.perPage)[this.currentPage - 1]
    },
    computed: {
        dublicates() {
            return this.searchDublicates();
        },
        currentFrom() {
            if(this.selectedMonth) {
                return this.selectedYear + "-" + this.selectedMonth + "-01"
            } else if (this.selectedYear) {
                return this.selectedYear + "-01-01"
            } else {
                return ''
            }
        },
        count() {
            return this.caravanDates.length
        },
        total() {
            return this.$page.props.caravan.dates.list.length
        },
        years() {
            return this.years ?? [];
        },
        months() {
            if(this.selectedYear) {
                return this.monthsByYear[this.selectedYear];
            }
            return []
        },
        priceTotel() {
            let total = 0;
            for(let i of this.caravanDates) {
                total += i.price
            }
            return total
        },
    },
    methods: {
        setDataAndPages(data) {
            this.caravanDates = data
            if(data.length > this.perPage) {
                this.paginated = this.chunks(data, this.perPage)[this.currentPage - 1]
            } else {
                this.paginated = data
            }
        },
        onPageClick(currentPage){
            this.currentPage = currentPage
            let arr = this.chunks(this.$page.props.caravan.dates.list, this.perPage)
            if(this.currentPage <= arr.length) {
                this.paginated = arr[this.currentPage - 1]
            }
        },
        searchDublicates() {
            let d = [],k,item, items=this.$page.props.caravan.dates.list;
            for(item of items) {
                items.forEach(i => {
                    if( item.id !== i.id && item.caravan_id === i.caravan_id
                        &&
                        (dayjs(item.from).isBetween(i.from, i.until, null, [])
                            ||
                            dayjs(item.until).isBetween(i.from, i.until, null, [])
                        )
                    ) {
                        if(d.indexOf(i.carnumber) === -1) {
                            d.push(i.carnumber)
                        }
                    }
                })
            }
            return d
        },
        reset() {
            this.selectedYear = null
            this.selectedMonth = null
            this.frmFilter.dublicate = null
            this.selectedCaravan = null
            this.currentPage = 1
            this.caravanDates = this.chunks(this.$page.props.caravan.dates.list, this.perPage)[this.currentPage - 1]
            this.frmFilter.reset()
        },
        onSelectCaravan(id) {
            this.selectedCaravan = ("" !== id) ? parseInt(id) : null;
            if(this.selectedCaravan) {
                let data = this.$page.props.caravan.dates.list.filter(item => {
                    if(item.caravan_id == this.selectedCaravan) {
                        return item
                    }
                });
                this.setDataAndPages(data)
            }
        },
        onSelectDublicate(carnumber) {
            if("" !== carnumber) {
                this.selectedDublicate = carnumber
                let data = this.$page.props.caravan.dates.list.filter(item => {
                    if(item.carnumber == this.selectedDublicate) {
                        return item
                    }
                });
                this.setDataAndPages(data)
            }
        },
        onSelectYear(year) {
            this.selectedYear = ("" !== year) ? parseInt(year) : null;
            if(this.selectedYear) {
                let data = this.$page.props.caravan.dates.list.filter(item => {
                    if(dayjs(item.from).year() === this.selectedYear) {
                        return item
                    }
                });
                this.setDataAndPages(data)
            }
        },
        onSelectMonth(month) {
            this.selectedMonth = ("" !== month) ? parseInt(month) : null;
            if(this.selectedMonth) {
                let data = this.$page.props.caravan.dates.list.filter(item => {
                    let fromMonth = parseInt(dayjs(item.from).month()) + 1,
                        fromYear = parseInt(dayjs(item.from).year());

                    if (fromYear == this.selectedYear && fromMonth == this.selectedMonth) {
                        return item
                    }
                });
                this.setDataAndPages(data)
            }
        },
        sendExcel() {
            this.frmSendExcel.from = this.currentFrom
            axios.post(route('caravanDates.sendExcel', this.frmSendExcel), this.frmSendExcel)
                .then(resp => {
                    if(resp.data.success) {
                        alert('Excel-Tabelle erfolgreich an ' + this.frmSendExcel.email + ' versand.')
                    } else if(resp.data.error) {
                        alert('Fehler: ' + resp.data.error)
                    }
                })
                .catch(err => console.error(err))
            ;
        },
        remove(item) {
            if(confirm('Datensatz (ID: ' + item.id + ') wirklich löschen?')) {
                Inertia.delete(route('caravanDates.destroy', item), {
                    onSuccess: (resp) => {
                        let data = this.caravanDates.filter(i => i !== item)
                        this.setDataAndPages(data)
                    }
                })
            }
        }
    }
}
</script>

<style scoped>
</style>
