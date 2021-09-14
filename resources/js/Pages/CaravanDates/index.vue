<template>
    <DefaultLayout title="Wohnwagen Rezeption">
        <div class="w-full flex">
            <div class="object-left-top">
                <MyLink :href="create_url"
                        icon="far fa-plus-square"
                        ctrClass="ml-2 my-2 p-5 no-hide-text"
                        title="neue Caravan Ankunft eintragen">
                    Neueintrag
                </MyLink>
            </div>
            <div v-if="caravanDates.length > 0" class="object-right-top">
                <MyLink :href="'/caravan/price/excel/' + currentFrom"
                        icon="far fa-file-excel"
                        ctrClass="ml-2 my-2 p-5 no-hide-text"
                        no-inertia="true"
                        target="_blank"
                        title="neue Caravan Ankunft eintragen">
                    Excel Download
                </MyLink>
            </div>
        </div>

        <MyForm :data="filter" css="flex-inline" @submit.prevent>
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
            <Button v-if="caravans.length > 0 || years.length > 0 || months !== undefined" @click="reset" css="inline w-1/6 ml-3" btnCss="btn btn-second">Reset</Button>
        </MyForm>
        <h5>{{ count }} Einträge</h5>
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
            <tr v-for="item in caravanDates" :key="item.id">
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

const currentYear = dayjs().year(),
    currentMonth = dayjs().month() + 1;

export default {
    name: "index",
    components: {
        MyLink,
        SelectFilter,
        SelectYear,
        SelectMonth,
        MyForm,
        DefaultLayout,
        NavLink,
        Button,
        ResponsiveNavLink,
    },
    mixins: [DateFormat],
    props: {
        caravans: Array,
        years: Array,
        monthsByYear: Array,
        create_url: String,
    },
    data() {
        return {
            caravanDates: this.$page.props.caravan.dates.list ?? [],
            selected: null,
            selectedYear: null,
            selectedMonth: null,
            selectedCaravan: null,
            selectedDublicate: null,
            filter: this.$inertia.form({
                year: null,
                month: null,
                caravan: null,
                dublicate: null,
            }),
        }
    },
    created() {
//        this.onSelectYear(currentYear)
//        this.onSelectMonth(currentMonth)
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
            var total = 0;
            for(let i of this.caravanDates) {
                total += i.price
            }
            return total
        },
    },
    methods: {
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
            this.filter.dublicate = null
            this.selectedCaravan = null
            this.caravanDates = this.$page.props.caravan.dates.list
            this.filter.reset()
        },
        onSelectCaravan(id) {
            this.selectedCaravan = ("" !== id) ? parseInt(id) : null;
            if(this.selectedCaravan) {
                this.caravanDates = this.$page.props.caravan.dates.list.filter(item => {
                    if(item.caravan_id == this.selectedCaravan) {
                        return item
                    }
                });
            }
        },
        onSelectDublicate(carnumber) {
            if("" !== carnumber) {
                this.selectedDublicate = carnumber
                this.caravanDates = this.$page.props.caravan.dates.list.filter(item => {
                    if(item.carnumber == this.selectedDublicate) {
                        return item
                    }
                });
            }
        },
        onSelectYear(year) {
            this.selectedYear = ("" !== year) ? parseInt(year) : null;
            if(this.selectedYear) {
                this.caravanDates = this.$page.props.caravan.dates.list.filter(item => {
                    if(dayjs(item.from).year() === this.selectedYear) {
                        return item
                    }
                });
            }
        },
        onSelectMonth(month) {
            this.selectedMonth = ("" !== month) ? parseInt(month) : null;
            if(this.selectedMonth) {
                this.caravanDates = this.$page.props.caravan.dates.list.filter(item => {
                    let fromMonth = parseInt(dayjs(item.from).month()) + 1,
                        fromYear = parseInt(dayjs(item.from).year());

                    if (fromYear == this.selectedYear && fromMonth == this.selectedMonth) {
                        return item
                    }
                });
            }
        },
        remove(item) {
            if(confirm('Datensatz (ID: ' + item.id + ') wirklich löschen?')) {
                Inertia.delete(route('caravanDates.destroy', item), {
                    onSuccess: (resp) => {
                        this.caravanDates = this.caravanDates.filter(i => i !== item)
                    }
                })
            }
        }
    }
}
</script>

<style scoped>
</style>
