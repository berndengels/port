<template>
    <div class="mb-5">
        <h5>Liegeplatz Gruppen Eingeschaften</h5>
        <BerthsCalculationForm class="m-3"
                :data="calcData"
                id="frmBerthCalculate"
        >
            <MyCheckbox name="enabled" label="Aktiv" @change="onChange" />
            <MySelect name="boat_dock_id" label="Steg" :options="docksOptions" @change="onChange" />
            <MyInputNumber name="start" label="Startnummer" placeholder="Startnummer"
                 type="number"
                 step="1"
                 min="1"
                 @change="onChange"
            />
            <MyInputNumber name="end" label="Endnummer" placeholder="Endnummer"
                type="number"
                step="1"
                min="1"
                @change="onChange"
            />
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
            <MyButton css="btn btn-save" name="btnClose" @click.prevent="$emit('closeCalcForm', false)">Schliessen</MyButton>
        </BerthsCalculationForm>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import MyInput from "v@/components/form/berthsCalculation/elements/MyInput";
import MyCheckbox from "v@/components/form/berthsCalculation/elements/MyCheckbox";
import MyInputNumber from "v@/components/form/berthsCalculation/elements/MyInputNumber";
import BerthsCalculationForm from "v@/components/form/berthsCalculation/BerthsCalculationForm";
import MySelect from "v@/components/form/berthsCalculation/elements/MySelect";
import MyButton from "v@/components/form/MyButton";

export default {
    name: "FormCalculateBerths",
    components: {MyButton, MySelect, BerthsCalculationForm, MyInput, MyInputNumber, MyCheckbox},
    computed: {
        ...mapGetters({
            calcData: "guestboatBerth/calcData",
            docksOptions: "guestboatBerth/docksOptions",
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
            this.setCalcData({ ...this.calcData, [e.target.name]: e.target.value });
        },
        close() {
            this.$emit('closeCalcForm')
        },
        ...mapActions({
            setCalcData: "guestboatBerth/setCalcData",
            selectDock: "guestboatBerth/selectDock",
        }),
    }
}
</script>
