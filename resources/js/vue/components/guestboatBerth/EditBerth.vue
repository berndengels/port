<template>
    <div class="mb-5">
        <h5>Liegeplatz {{ selected.number ?? '' }}</h5>
        <form class="frmMap m-3">
            <div>
                <label for="enabled">Aktiv</label>
                <input type="checkbox" id="enabled" v-model="selected.enabled" />
            </div>

            <div>
                <label for="enabled">Steg</label>
                <select id="boat_dock_id" v-model="selected.boat_dock_id">
                    <option
                        v-if="docksOptions"
                        v-for="opt in docksOptions"
                        :key="opt.id"
                        :value="opt.id"
                    >{{ opt.name }}</option>
                </select>
            </div>

            <div>
                <label for="number">Nummer</label>
                <input type="number" id="number" v-model="selected.number" min="1" step="1" />
            </div>

            <div>
                <label for="width">Breite</label>
                <input type="number" id="width" v-model="selected.width" min="1" step="0.1" />
            </div>
            <div>
                <label for="number">Länge</label>
                <input type="number" id="length" v-model="selected.length" min="1" step="0.1" />
            </div>
            <div>
                <label for="number">Tagespreis</label>
                <input type="number" id="daily_price" v-model="selected.daily_price" min="1" step="1" />
            </div>

            <div class="mt-5">
                <MyButton inline="true" @click.prevent="save" >Speichen</MyButton>
                <MyButton inline="true" @click.prevent="$emit('showEditForm', false)">Schliessen</MyButton>
            </div>
        </form>
    </div>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from "vuex";
import MyButton from "v@/components/form/MyButton";

export default {
    name: "EditBerth",
    components: {MyButton},
    computed: {
        enabled: {
            get() {
                return this.$store.state.guestboatBerth.selected.enabled
            },
            set(value) {
                console.info("set selected", value)
//                this.updateSelected({ ...this.selected, value });
                this.updateFormSelected.commit({
                    ...this.$store.state.guestboatBerth.selected,
                    [property]: value
                })

            }
        },
        boat_dock_id: {
            get() {
                return this.$store.state.guestboatBerth.selected.boat_dock_id
            },
            set(value) {
                console.info("set selected", value)
//                this.updateSelected({ ...this.selected, value });
                this.updateFormSelected.commit({
                    ...this.$store.state.guestboatBerth.selected,
                    [property]: value
                })

            }
        },
        number: {
            get() {
                return this.$store.state.guestboatBerth.selected[property]
            },
            set(value) {
                console.info("set selected", value)
//                this.updateSelected({ ...this.selected, value });
                this.updateFormSelected.commit({
                    ...this.$store.state.guestboatBerth.selected,
                    [property]: value
                })

            }
        },
        ...mapGetters({
//            selected: "guestboatBerth/selected",
            errors: "guestboatBerth/errors",
            docksOptions: "guestboatBerth/docksOptions",
        }),
    },
    methods: {
        save() {
            this.update(this.selected);
            this.select(null)
        },
        close() {
            this.select(null)
        },
        ...mapActions({
            update: "guestboatBerth/update",
            select: "guestboatBerth/select",
        }),
        ...mapMutations({
            updateFormSelected: "guestboatBerth/updateFormSelected",
        }),
    }
}
</script>

<style scoped>
</style>
