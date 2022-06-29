<template>
    <div class="m-5">
        <div v-if="!loaded" class="flex items-center justify-center h-screen">
            <PulseLoader :size="loaderSize" :color="loaderColor" />
        </div>
        <div v-else>
            <Map
                id="mapBerths"
                :data="data"
                @showEditForm="handleEditForm"
            />
            <Edit
                v-if="selected"
                v-show="showEditForm"
                :data="selected.properties"
                :errors="errors"
                @showEditForm="handleEditForm"
            />
            <FormCalculateBerths
                v-show="showCalculationForm"
                @showCalculationForm="handleCalculationForm"
            />
            <Table
                :data="data"
                @showEditForm="handleEditForm"
            />
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import Map from "v@/components/guestboatBerth/Map";
import Table from "v@/components/guestboatBerth/Table";
import Edit from "v@/components/guestboatBerth/Edit";
import FormCalculateBerths from "v@/components/guestboatBerth/FormCalculateBerths";

export default {
    name: "GuestboatBerths",
    components: {FormCalculateBerths, Edit, Table, Map, PulseLoader},
    data() {
        return {
            showCalculationForm: false,
            showEditForm: false,
            loading: true,
            loaderColor: '#007700',
            loaderSize: '40px',
        }
    },
    created() {
        this.$store.dispatch("guestboatBerth/fetchData")
    },
    computed: {
        ...mapGetters({
            data: "guestboatBerth/data",
            selected: "guestboatBerth/selected",
            errors: "guestboatBerth/errors",
        }),
        loaded() {
            return !!this.$store.state.guestboatBerth.data;
        }
    },
    methods: {
        ...mapActions({
            select: "guestboatBerth/select",
        }),
        handleGeoDataChanged(item) {
            this.select(item)
        },
        handleEditForm(show) {
            this.showEditForm = show
        },
        handleCalculationForm(show) {
            this.showEditForm = show
        },
    }
}
</script>
