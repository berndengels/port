<template>
    <DefaultLayout title="Wohnmobil bearbeiten">
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
            <DateInput name="from" label="Von" required @change="change" />
            <DateInput name="until" label="Von" required @change="change" />
            <Input name="price" label="Preis" required />
            <Button @click="update" btnCss="btn btn-save">Speichen</Button>
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
import DateFormat from "../../Mixins/DateFormat";
import AppLayout from "../../Layouts/AppLayout";
import axios from 'axios';
import DefaultLayout from "../../Layouts/DefaultLayout";

export default {
    name: "edit",
    components: {
        DefaultLayout,
        Checkbox,
        Button,
        MyForm,
        DateInput,
        Input,
        Autocomplete,
    },
    props: ['caravans','caravanDate'],
    mixins: [DateFormat],

    data() {
        return {
            form: this.$inertia.form({
//                _method: 'PUT',
                id: this.caravanDate.id,
                caravan_id: this.caravanDate.caravan_id,
                carnumber: this.caravanDate.caravan.carnumber,
                carlength: this.caravanDate.caravan.carlength,
                persons: this.caravanDate.persons,
                from: this.formatDateInput(this.caravanDate.from),
                until: this.formatDateInput(this.caravanDate.until),
                electric: !!this.caravanDate.electric,
                price: this.caravanDate.price,
                prices: this.caravanDate.prices,
            }),
        }
    },

    methods: {
        update() {
            try {
                this.form.put(route('caravanDates.update', this.form), {
                    preserveScroll: true,
//                errorBag: 'errors',
//                onSuccess: (resp) => {},
                    onError: (err) => {
                        console.info('error')
                        console.info(err)
                    }
                });
            } catch(err) {
                console.info('error')
                console.info(err)
            }
        },
        onSelect(e) {
            let caravan = this.caravans.filter(i => i.carnumber === e.target.innerText).shift()
            if(caravan) {
                this.form.caravan_id = caravan.id
                this.form.carnumber = caravan.carnumber
                this.form.carlength = caravan.carlength
                console.info(caravan)
            }
        },
        change() {
            if(this.form.from && this.form.until && this.form.persons) {
                axios.post(route("caravan.price.calculate"), this.form)
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
