<template>
    <DefaultLayout title="Wohnwagen Dates">
        <nav-link :href="create_url" class="ml-2 my-2">
            Neueintrag
        </nav-link>

        <MyForm :data="dateFilter" css="flex-inline" @submit.prevent>
            <SelectYear name="year" label="Jahr" :options="years" @selectYear="onSelectYear" />
            <SelectMonth v-if="selectedYear" name="month" label="Monat" :options="months" @selectMonth="onSelectMonth"
                css="ml-3"
            />
        </MyForm>

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
            <tr v-for="item in caravanDates" :key="item.id">
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
    </DefaultLayout>
</template>

<script>
import ResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'
import { Inertia } from '@inertiajs/inertia'
import Button from "../../Jetstream/Button";
import NavLink from "../../Jetstream/NavLink";
import DateFormat from "../../Mixins/DateFormat";
import DefaultLayout from "../../Layouts/DefaultLayout";
import MyForm from "../../Components/Form/MyForm";
import SelectYear from "../../Components/Form/SelectYear";
import SelectMonth from "../../Components/Form/SelectMonth";

export default {
    name: "index",
    components: {
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
        data: Array,
        years: Array,
        monthsByYear: Array,
        create_url: String,
    },
    data() {
        return {
            caravanDates: this.data,
            selected: null,
            selectedYear: null,
            selectedMonth: null,
            dateFilter: this.$inertia.form({
                year: null,
                month: null,
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
        onSelect(item) {
            this.selected = item
        },
        onSelectYear(year) {
            this.selectedYear = ("" !== year) ? parseInt(year) : null;
            this.caravanDates = this.data.filter(item => {
                if(dayjs(item.from).year() === this.selectedYear) {
                    return item
                }
            });
        },
        onSelectMonth(month) {
            this.selectedMonth = ("" !== month) ? parseInt(month) : null;
            this.caravanDates = this.data.filter(item => {
                if (dayjs(item.from).year() === this.selectedYear && dayjs(item.from).month() === this.selectedMonth) {
                    return item
                }
            });
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
