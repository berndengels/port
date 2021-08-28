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
            <Input name="carlength" type="number" label="Länge Wohnmobil" required />
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

const apiURL = process.env.MIX_API_URL;

export default {
    name: "create",
    components: {
        DefaultLayout,
        Checkbox,
        Button,
        MyForm,
        DateInput,
        Input,
        Autocomplete,
    },
    props: ['caravans'],
    mixins: [DateFormat],
    data() {
        return {
            form: this.$inertia.form({
//                _method: 'POST',
                caravan_id: null,
                carnumber: null,
                carlength: null,
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
                errorBag: 'storeCaravanDates',
                preserveScroll: true,
                onSuccess: (resp) => {},
                onError: err => console.error(err),
            });
        },
        onSelect(e) {
            let caravan = this.caravans.filter(i => i.carnumber === e.target.innerText).shift()
            if(caravan) {
                this.form.caravan_id = caravan.id
                this.form.carnumber = caravan.carnumber
                this.form.carlength = caravan.carlength
            }
        },
        onInput() {
            return this.caravans
        },
        change() {
            if(this.form.from && this.form.until && this.form.persons) {
                axios.post(apiURL+"/caravan/price/calculate", this.form)
                    .then(resp => {
                        console.info(resp.data);
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
