<template>
    <DefaultLayout title="Wohnmobil anlegen">
        <MyForm :data="form" @submit.prevent>
            <input type="hidden" v-model="form.caravan_id" />
            <input type="hidden" v-model="form.prices" />
            <Autocomplete
                :data="caravans"
                name="carnumber"
                label="Autokennzeichen"
                key="id"
                @onSelect="onSelect"
                required
                autocomplete="off"
            />
            <Select name="country_id" label="Herkunftsland" :options="countries" />
            <Input name="carlength" type="number" label="Länge Wohnmobil" required />
            <Input name="email" type="email" label="Email" autocomplete="email" />
            <Input name="persons" type="number" label="Anzahl Personen" required @change="change" />
            <Checkbox name="electric" label="Strom-Anschluss" @change="change" />
            <DateInput name="from" label="Von" required  @change="change" />
            <DateInput name="until" label="Bis" required @change="change" />
            <Input name="price" label="Preis" />
            <div>
                <Button @click="store" btnCss="btn btn-save">Speichen</Button>
            </div>
        </MyForm>
    </DefaultLayout>
</template>

<script>
import Autocomplete from '@/Components/Form/Autocomplete'
import MyForm from "../../Components/Form/MyForm";
import DateInput from "../../Components/Form/DateInput";
import Input from "../../Components/Form/Input";
import Button from "../../Components/Form/Button";
import Checkbox from "../../Components/Form/Checkbox";
import axios from 'axios';
import DateFormat from "../../Mixins/DateFormat";
import DefaultLayout from "../../Layouts/DefaultLayout";
import Select from "../../Components/Form/Select";

export default {
    name: "create",
    components: {
        Select,
        DefaultLayout,
        Checkbox,
        Button,
        MyForm,
        DateInput,
        Input,
        Autocomplete,
    },
    props: ['caravans','countries'],
    mixins: [DateFormat],
    data() {
        return {
            form: this.$inertia.form({
//                _method: 'POST',
                caravan_id: null,
                country_id: 55,
                carnumber: null,
                carlength: null,
                email: null,
                persons: 2,
                from: this.formatDateInput((new Date().toDateString())),
                until: null,
                electric: true,
                price: null,
                prices: null,
            }),
        }
    },

    methods: {
        store() {
            this.form.post(route('caravanDates.store'), {
                preserveScroll: true,
/*
                onSuccess: (resp) => {
                    this.$inertia.visit(route('caravanDates.show', resp.id),{
                        method: 'get',
//                        only: ['caravan.dates.list']
                    })
                },
*/
            });
        },
        onSelect(e) {
            let caravan = this.caravans.filter(i => i.carnumber === e.target.innerText).shift()
            if(caravan) {
                this.form.caravan_id = caravan.id
                this.form.country_id = caravan.country_id
                this.form.carnumber = caravan.carnumber
                this.form.carlength = caravan.carlength
                this.form.email = caravan.email
            }
        },
        onInput() {
            return this.caravans
        },
        change() {
            if(this.form.from && this.form.until && this.form.persons) {
                axios.post(route("caravan.price.calculate"), this.form)
                    .then(resp => {
                        this.form.price = resp.data.total
                        this.form.prices = JSON.stringify(resp.data.prices)
                    })
                    .catch(err => console.error(err))
                ;
            }
        }
    }
}
</script>

<style scoped>
</style>
