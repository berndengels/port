<template>
    <div class="mb-5">
        <h5>Liegeplatz Gruppen Eingeschaften</h5>
        <BerthsCalculationForm class="m-3"
                :data="calcData"
                id="frmBerthCalculate"
        >
            <MyCheckbox name="enabled" label="Aktiv" @change="onChange" />
            <MyInput name="prefix" label="Prefix" @change="onChange" />

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
            <div class="mt-5">
                <MyButton inline="true" @click.prevent="$emit('showCalculationForm', false)">Schliessen</MyButton>
            </div>
        </BerthsCalculationForm>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import MyInput from "v@/components/form/berthsCalculation/elements/MyInput";
import MyCheckbox from "v@/components/form/berthsCalculation/elements/MyCheckbox";
import MyButton from "v@/components/form/MyButton";
import MyInputNumber from "v@/components/form/berthsCalculation/elements/MyInputNumber";
import BerthsCalculationForm from "v@/components/form/berthsCalculation/BerthsCalculationForm";

export default {
    name: "FormCalculateBerths",
    components: {BerthsCalculationForm, MyInput, MyInputNumber, MyCheckbox, MyButton},
    computed: {
        ...mapGetters({
            calcData: "guestboatBerth/calcData",
        }),
    },
    methods: {
        onChange(e) {
            this.setCalcData({ ...this.calcData, [e.target.name]: e.target.value });
        },
        close() {
            this.$emit('closeCalcForm')
        },
        ...mapActions({
            setCalcData: "guestboatBerth/setCalcData",
        }),
    }
}
</script>
