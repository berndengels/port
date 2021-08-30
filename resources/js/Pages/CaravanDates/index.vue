<template>
    <DefaultLayout title="Wohnwagen Dates">
        <nav-link :href="create_url" class="ml-2 my-2">
            Neueintrag
        </nav-link>

        <MyForm :data="filter" css="flex-inline" @submit.prevent>
            <SelectYear name="year" label="Jahr" :options="years"
                @selectYear="onSelectYear"
            />
            <SelectMonth v-if="selectedYear" name="month" label="Monat" :options="months"
                @selectMonth="onSelectMonth"
                css="ml-3"
            />
            <SelectFilter name="caravan" label="Kennzeichen" keyName="id" field="carnumber"
                :options="caravans"
                @selectedCaravan="onSelectCaravan"
            />
            <Button @click="reset" css="inline w-1/6 ml-3" btnCss="btn btn-second">Reset</Button>
        </MyForm>

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
                <td><NavLink :href="item.show_url">{{ item.carnumber }}</NavLink></td>
                <td>{{ item.carlength }} m</td>
                <td>{{ formatDate(item.from) }}</td>
                <td>{{ formatDate(item.until) }}</td>
                <td>{{ item.days }}</td>
                <td>{{ item.price }}</td>
                <td><NavLink :href="item.edit_url">Edit</NavLink></td>
                <td><Button @click="remove(item)" btnCss="btn btn-red">Löschen</Button></td>
            </tr>
            <tr>
                <th>Preis Total</th>
                <td colspan="8">{{ priceTotel }} €</td>
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

export default {
    name: "index",
    components: {
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
            filter: this.$inertia.form({
                year: null,
                month: null,
                caravan: null,
            }),
        }
    },
    computed: {
        years() {
            return this.years;
        },
        months() {
            if(this.selectedYear) {
                return this.monthsByYear[this.selectedYear];
            }
        },
        priceTotel() {
            var total = 0;
            for(let i of this.caravanDates) {
                total += i.price
            }
            return total
        }
    },
    methods: {
        reset() {
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
//                Inertia.delete('caravanDates/' + item.id, item)
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
