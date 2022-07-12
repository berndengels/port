<template>
    <div class="m-5">
        <div v-if="!loaded" class="flex items-center justify-center h-screen">
            <PulseLoader :size="loaderSize" :color="loaderColor" />
        </div>
        <div v-else>
            <Map v-if="portData"
                :port-data="portData"
                :data="data"
                @showEditForm="handleEditForm"
            />
            <EditBerth
                v-if="showEditForm"
                @showEditForm="handleEditForm"
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
import EditBerth from "v@/components/guestboatBerth/EditBerth";

export default {
    name: "GuestboatBerths",
    components: {EditBerth, Table, Map, PulseLoader},
    data() {
        return {
            showCalculationForm: false,
            showEditForm: false,
            loading: true,
            loaderColor: '#007700',
            loaderSize: '40px',
        }
    },
    beforeCreate() {
        this.$store.dispatch("guestboatBerth/fetchPortData");
        this.$store.dispatch("guestboatBerth/fetchData");
        this.$store.dispatch("guestboatBerth/fetchDocks");
        this.$store.dispatch("guestboatBerth/fetchCategories")
    },
    computed: {
        ...mapGetters({
            data: "guestboatBerth/data",
            portData: "guestboatBerth/portData",
            errors: "guestboatBerth/errors",
        }),
        loaded() {
            return !!this.$store.state.guestboatBerth.data || null === this.$store.state.guestboatBerth.data;
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
