<template>
    <div>
        <form @submit.prevent>
            <ValidationErrors />
            <div>
                <jet-label for="carnumber" value="Autokennzeichen" />
                <jet-input id="carnumber" type="text" class="mt-1 block w-full" v-model="form.carnumber" required autofocus autocomplete="carnumber" />
                <div>
                    <Autocomplete
                        :results="caravans"
                        :displayItem="item.carnumber"
                        @onSelect="select"
                        @input="form.carnumber"
                    ></Autocomplete>
                </div>
            </div>
            <div>
                <jet-label for="carlength" value="Länge" />
                <jet-input id="carlength" type="text" class="mt-1 block w-full" v-model="form.carlength" required autofocus autocomplete="carnumber" />
            </div>
            <div>
                <jet-label for="persons" value="Personen" />
                <jet-input id="persons" type="text" class="mt-1 block w-full" v-model="form.persons" required autofocus autocomplete="persons" />
            </div>
            <div>
                <jet-label for="from" value="Von" />
                <jet-input id="from" type="date" class="mt-1 block w-full" v-model="form.from" required autofocus autocomplete="from" />
            </div>
            <div>
                <jet-label for="until" value="Bis" />
                <jet-input id="until" type="date" class="mt-1 block w-full" v-model="form.until" required autofocus autocomplete="until" />
            </div>
            <div>
                <jet-label for="price" value="Preis in €" />
                <jet-input id="price" type="text" class="mt-1 block w-full" v-model="form.price" required autofocus autocomplete="price" />
            </div>
            <div>
                <jet-button @click="update" />
            </div>
        </form>
    </div>
</template>

<script>
import JetButton from '@/Jetstream/Button.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import ValidationErrors from "../../Jetstream/ValidationErrors";
import Autocomplete from 'vue3-autocomplete'
// Optional: Import default CSS
import 'vue3-autocomplete/dist/vue3-autocomplete.css'

export default {
    name: "edit",
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
    props: ['caravanDates','caravans'],
    data() {
        return {
            form: this.$inertia.form({
                _method: 'PUT',
                carnumber: this.caravanDates.caravan.carnumber,
                carlength: this.caravanDates.caravan.carlength,
                persons: this.caravanDates.persons,
                from: this.caravanDates.from,
                until: this.caravanDates.until,
                price: this.caravanDates.price,
            }),
        }
    },

    methods: {
        update() {
            this.form.put(route('caravanDates.update'), {
                errorBag: 'updateCaravanDates',
                preserveScroll: true,
                onSuccess: (resp) => {},
            });
        },
        select(item) {
            console.info(item);
        },
        change(item) {
            console.info(item);
        }
    }
}
</script>

<style scoped>
</style>
