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
            <Input type="email" name="email" label="Email" />
            <Input name="persons" type="number" label="Anzahl Personen" required @change="change" />
            <Checkbox name="electric" label="Strom-Anschluss" @change="change" />
            <DateInput name="from" label="Von" required @change="change" />
            <DateInput name="until" label="Bis" required @change="change" />
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3 text-right">
                    <span>Differenz zum ursprünglicher Preis: </span>
                </div>
                <div class="md:w-2/3">
                    <span class="w-full py-2 px-4 text-gray-700 leading-tight">
                        {{ diffPrice }}
                    </span>
                </div>
            </div>

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
import Label from "../../Components/Form/Label";
import Button from "../../Components/Form/Button";
import Checkbox from "../../Components/Form/Checkbox";
import DateFormat from "../../Mixins/DateFormat";
import AppLayout from "../../Layouts/AppLayout";
import axios from 'axios';
import DefaultLayout from "../../Layouts/DefaultLayout";
import ActionMessage from "../../Jetstream/ActionMessage";

export default {
    name: "edit",
    components: {
        ActionMessage,
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
                email: this.caravanDate.caravan.email,
                carlength: this.caravanDate.caravan.carlength,
                persons: this.caravanDate.persons,
                from: this.formatDateInput(this.caravanDate.from),
                until: this.formatDateInput(this.caravanDate.until),
                electric: !!this.caravanDate.electric,
                price: this.caravanDate.price,
                prices: this.caravanDate.prices,
            }),
            initialPrice: parseInt(this.caravanDate.price),
            diffPrice: 0,
        }
    },

    methods: {
        update() {
            try {
                this.form.put(route('caravanDates.update', this.form), {
                    preserveScroll: true,
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
                this.form.email = caravan.email
            }
        },
        change() {
            if(this.form.from && this.form.until && this.form.persons) {
                axios.post(route("caravan.price.calculate"), this.form)
                    .then(resp => {
                        this.form.price = resp.data.total
                        this.form.prices = JSON.stringify(resp.data.prices)
                        this.diffPrice = parseInt(this.form.price) - parseInt(this.initialPrice)
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
