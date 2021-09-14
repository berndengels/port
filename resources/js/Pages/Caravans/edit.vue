<template>
    <DefaultLayout title="Wohnwagen">
        <MyLink :href="route('caravans.index')" icon="fas fa-backward">zurück</MyLink>
        <MyForm :data="form" @submit.prevent>
            <Select name="country_id" label="Herkunftsland" :options="countries" />
            <Input name="carnumber" label="Autokennzeichen" required="true" />
            <Input type="number" name="carlength" label="Länge" required="true" />
            <Input type="email" name="email" label="Email" />
            <Button @click.prevent="update" btnCss="btn btn-save">Speichern</Button>
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
    name: "edit",
    components: {
        MyLink,
        Select,
        Button,
        Input,
        MyForm,
        DefaultLayout,
    },
    props: ['caravan','countries'],
    data() {
        return {
            form: this.$inertia.form({
                _method: 'PUT',
                id: this.caravan.id,
                country_id: this.caravan.country_id ?? 55,
                carnumber: this.caravan.carnumber,
                carlength: this.caravan.carlength,
                email: this.caravan.email,
            }),
        }
    },

    methods: {
        update() {
            this.form.put(route('caravans.update', this.form), {
                preserveScroll: true,
                onSuccess: (resp) => {},
            });
        },
    }
}
</script>

<style scoped>
</style>
