<template>
    <AppLayout title="Wohnwagen">
        <form @submit.prevent>
            <ValidationErrors />
            <div>
                <jet-label for="carnumber" value="Autokennzeichen" />
                <jet-input id="carnumber" type="text" class="mt-1 block w-full" v-model="form.carnumber" required autofocus autocomplete="carnumber" />
            </div>
            <div>
                <jet-label for="carlength" value="Länge" />
                <jet-input id="carlength" type="text" class="mt-1 block w-full" v-model="form.carlength" required autofocus autocomplete="carnumber" />
            </div>
            <div>
                <jet-button @click="update">Speichern</jet-button>
            </div>
        </form>
    </AppLayout>
</template>

<script>
import JetButton from '@/Jetstream/Button.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import AppLayout from "../../Layouts/AppLayout";
import FormSection from "../../Jetstream/FormSection";
import ValidationErrors from "../../Jetstream/ValidationErrors";

export default {
    name: "edit",
    components: {
        ValidationErrors,
        FormSection,
        AppLayout,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
    },
    props: ['caravan'],
    data() {
        return {
            form: this.$inertia.form({
                _method: 'PUT',
                id: this.caravan.id,
                carnumber: this.caravan.carnumber,
                carlength: this.caravan.carlength,
            }),
        }
    },

    methods: {
        update() {
            this.form.put(route('caravans.update', this.form), {
                errorBag: 'updateCaravan',
                preserveScroll: true,
                onSuccess: (resp) => {},
            });
        },
    }
}
</script>

<style scoped>
</style>
