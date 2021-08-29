<template>
    <DefaultLayout title="Wohnwagen">
        <MyForm :data="form" @submit.prevent>
            <Input name="carnumber" label="Autokennzeichen" required />
            <Input name="carlength" label="Länge" required />
            <Input type="email" name="email" label="Email" />
            <Button @click.prevent="store" btnCss="btn btn-save">Speichern</Button>
        </MyForm>
    </DefaultLayout>
</template>

<script>
import DefaultLayout from "../../Layouts/DefaultLayout";
import MyForm from "../../Components/Form/MyForm";
import Input from "../../Components/Form/Input";
import Button from "../../Jetstream/Button";

export default {
    name: "create",
    components: {
        Button,
        Input,
        MyForm,
        DefaultLayout,
    },

    data() {
        return {
            form: this.$inertia.form({
                _method: 'POST',
                carnumber: null,
                carlength: null,
                email: null,
            }),
        }
    },

    methods: {
        store() {
            this.form.post(route('caravans.store'), {
                preserveScroll: true,
                onSuccess: (resp) => {},
            });
        },
    }
}
</script>

<style scoped>
</style>
