<template>
    <div>
        <form @submit.prevent>
            <ValidationErrors />
            <jet-input type="hidden" v-model="form.caravan_id" />
            <jet-input type="hidden" v-model="form.prices" />
            <div>
                <jet-label for="carnumber" value="Autokennzeichen" />
                <Autocomplete
                    :data="caravans"
                    :form="form"
                    v-model="form.carnumber"
                    name="carnumber"
                    key="id"
                    @onSelect="onSelect"
                />
            </div>
            <div>
                <jet-label for="carlength" value="Länge" />
                <jet-input id="carlength" type="text" class="mt-1 block" v-model="form.carlength" required autofocus autocomplete="false" />
            </div>
            <div>
                <jet-label for="persons" value="Personen" />
                <jet-input id="persons" type="text" class="mt-1 block" v-model="form.persons" required autofocus autocomplete="persons"
                            @change="change"
                />
            </div>
            <div>
                <jet-label for="electric" value="Strom-Anschluss" />
                <jet-input id="electric" type="checkbox" class="mt-1 block" v-model="form.electric" required autofocus
                           :checked="this.form.electric"
                           @change="change"
                />
            </div>
            <div>
                <jet-label for="from" value="Von" />
                <jet-input id="from" type="date" class="mt-1 block" v-model="form.from" required autofocus autocomplete="from"
                           @change="change"
                />
            </div>
            <div>
                <jet-label for="until" value="Bis" />
                <jet-input id="until" type="date" class="mt-1 block" v-model="form.until" required autofocus autocomplete="until"
                           @change="change"
                />
            </div>
            <div>
                <jet-label for="price" value="Preis in €" />
                <jet-input id="price" type="text" class="mt-1 block" v-model="form.price" required autofocus autocomplete="price" />
            </div>
            <div>
                <jet-button @click="store">Speichen</jet-button>
            </div>
        </form>
    </div>
</template>

<script>
import JetButton from '@/Jetstream/Button.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import ValidationErrors from "@/Jetstream/ValidationErrors";
import Autocomplete from '@/Components/Form/Autocomplete'
import axios from 'axios';

const apiURL = 'http://port.test';

export default {
    name: "create",
    components: {
        ValidationErrors,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        Autocomplete,
    },
    props: ['caravans'],
    data() {
        return {
            form: this.$inertia.form({
                _method: 'POST',
                caravan_id: null,
                carnumber: null,
                carlength: null,
                persons: 2,
                from: null,
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
                onError: err => alert(err),
            });
        },
        onSelect(target) {
            let caravan = this.caravans.filter(i => i.carnumber === target.innerText).shift()
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
                axios.post(apiURL+"/caravan/price/calculate", this.form).then(resp => {
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
