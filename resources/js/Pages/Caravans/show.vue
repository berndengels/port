<template>
    <DefaultLayout title="Wohnwagen">
        <MyLink :href="route('caravans.index')" icon="fas fa-backward">zurück</MyLink>

    </DefaultLayout>
</template>

<script>
import DefaultLayout from "../../Layouts/DefaultLayout";
import MyLink from "../../Components/Form/MyLink";
export default {
    name: "show",
    components: {MyLink, DefaultLayout}
}
</script>

<style scoped>
</style>
