<template>
    <div class="mb-5">
        <h5>Liegeplatz {{ data.number ?? '' }}</h5>
        <MyBerthForm class="m-3"
                id="frmEdit"
                :data="data"
                :errors="errors"
        >
            <MyCheckbox name="enabled" label="Aktiv" @change="onChange" />
            <MySelect name="boat_dock_id" label="Steg" :options="docksOptions" @change="onChange" />
            <MyInput name="number" label="Nummer" @change="onChange" />
            <MyInputNumber name="width" label="Breite" placeholder="Breite"
                type="number"
                step="0.1"
                min="1"
                @change="onChange"
            />
            <MyInputNumber name="length" label="Länge" placeholder="Länge"
                type="number"
                step="0.1"
                min="1"
                @change="onChange"
            />
            <MyInputNumber name="daily_price" label="Tagespreis" placeholder="Tagespreis"
                type="number"
                step="1"
                min="1"
                @change="onChange"
            />
            <div class="mt-5">
                <MyButton inline="true" @click.prevent="save" >Speichen</MyButton>
                <MyButton inline="true" @click.prevent="$emit('showEditForm', false)">Schliessen</MyButton>
            </div>
        </MyBerthForm>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import MyInput from "v@/components/form/berth/elements/MyInput";
import MyCheckbox from "v@/components/form/berth/elements/MyCheckbox";
import MyButton from "v@/components/form/MyButton";
import MyInputNumber from "v@/components/form/berth/elements/MyInputNumber";
import MyBerthForm from "v@/components/form/berth/MyBerthForm";
import MySelect from "v@/components/form/berth/elements/MySelect";

export default {
    name: "Edit",
    components: {MySelect, MyBerthForm, MyInput, MyInputNumber, MyCheckbox, MyButton},
    props: ['data', 'docksOptions'],
    data() {
        return {
            overlayData: null,
        }
    },
    computed: {
        ...mapGetters({
            selected: "guestboatBerth/selected",
            errors: "guestboatBerth/errors",
        }),
    },
    methods: {
        onChange(e) {
            if("boat_dock_id" === e.target.name) {
                this.selectDock({
                    id: e.target.value,
                    name: e.target.innerText,
                });
            }
            const data = {
                type: this.selected.type,
                geometry: this.selected.geometry,
                properties: { ...this.selected.properties, [e.target.name]: e.target.value  }
            };
            this.select(data);
            emitter.emit('geoDataChanged', data);
        },
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
    }
}
</script>

<style scoped>
</style>
