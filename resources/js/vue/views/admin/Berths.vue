<template>
    <div class="m-5">
        <!--div v-if="!loaded" class="flex items-center justify-center h-screen">
            <PulseLoader :size="loaderSize" :color="loaderColor" />
        </div-->
        <div>
            <Map @showEditForm="handleEditForm"/>
            <EditBerth v-if="selected" @showEditForm="handleEditForm"/>
            <Table @showEditForm="handleEditForm"/>
        </div>
    </div>
</template>

<script>
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import Map from "v@/components/berth/Map";
import Table from "v@/components/berth/Table";
import EditBerth from "v@/components/berth/EditBerth";
import {mapGetters} from "vuex";

export default {
    name: "Berths",
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
        this.$store.dispatch("berth/fetchPortData");
        this.$store.dispatch("berth/fetchData");
        this.$store.dispatch("berth/fetchDocks");
        this.$store.dispatch("berth/fetchCategories")
    },
    computed: {
        ...mapGetters({
            selected: "berth/selected",
        }),
    },
    methods: {
        handleEditForm(show) {
            this.showEditForm = show
        },
    }
}
</script>
