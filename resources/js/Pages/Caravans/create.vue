<template>
    <AppLayout title="Wohnwagen">
        <form @submit.prevent>
            <div>
                <jet-label for="carnumber" value="Autokennzeichen" />
                <jet-input id="carnumber" type="text" class="mt-1 block w-full"
                           v-model="form.carnumber" required autofocus autocomplete="carnumber" />
            </div>
            <div>
                <jet-label for="carlength" value="Länge" />
                <jet-input id="carlength" type="text" class="mt-1 block w-full"
                           v-model="form.carlength" required autofocus autocomplete="carlength" />
            </div>
            <div>
                <jet-button @click.prevent="store" />
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

export default {
    name: "create",
    components: {
        AppLayout,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
    },

    data() {
        return {
            form: this.$inertia.form({
                _method: 'POST',
                carnumber: null,
                carlength: null,
            }),
        }
    },

    methods: {
        store() {
            this.form.post(route('caravans.store'), {
//                errorBag: 'storeCaravan',
                preserveScroll: true,
                onSuccess: (resp) => {},
            });
        },
    }
}
</script>

<style scoped>
</style>
