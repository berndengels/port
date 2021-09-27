<template>
    <DefaultLayout title="Wohnmobil">
        <MyLink :href="route('caravans.index')" icon="fas fa-backward">zurück</MyLink>
        <MyForm :data="form" @submit.prevent>
            <Select name="country_id" label="Herkunftsland" :options="countries" />
            <Input name="carnumber" label="Autokennzeichen" required autocomplete />
            <Input name="carlength" label="Länge" type="number" required />
            <Input type="email" name="email" label="Email" autocomplete />
            <Button @click.prevent="store" btnCss="btn btn-save">Speichern</Button>
        </MyForm>
    </DefaultLayout>
</template>

<script>
import DefaultLayout from "../../Layouts/DefaultLayout";
import MyForm from "../../Components/Form/MyForm";
import Input from "../../Components/Form/Input";
import Button from "../../Jetstream/Button";
import Select from "../../Components/Form/Select";
import MyLink from "../../Components/Form/MyLink";

export default {
    name: "create",
    components: {
        MyLink,
        Select,
        Button,
        Input,
        MyForm,
        DefaultLayout,
    },
    props: ['countries'],
    data() {
        return {
            form: this.$inertia.form({
                _method: 'POST',
                country_id: 55,
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
