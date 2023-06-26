<template>
	<div class="m-0 p-0">
		<!--h5>Liegeplatz Gruppen Eingeschaften</h5-->
		<BerthsCalculationForm
			css="w-full m-0"
			:data="calcData"
			id="frmBerthCalculate"
		>
			<MyCheckbox name="enabled" label="Aktiv" @change="onChange"/>
			<MySelect name="dock_id" label="Steg" :options="docksOptions" @change="onChange"/>
			<MySelect v-if="categories" name="berth_category_id" label="Kategorie" :options="categories"
					  @change="onChange"/>
			<!--MySelect name="modus" label="gerade/ungerade Zählung" :options="optionsModus" @change="onChange" /-->
			<div>Zählart</div>
			<div class="form-check-inline mb-1">
				<MyRadio name="modus" id="m1" label="normal" value="1" @change="onChange"/>
				<MyRadio name="modus" id="m2" label="2er Schritt" value="2" class="ms-3" @change="onChange"/>
			</div>
			<MyInputNumber name="start" label="Startnummer" placeholder="Startnummer"
						   type="number"
						   step="1"
						   min="1"
						   @change="onChange"
			/>
			<MyInputNumber name="count" label="Anzahl" placeholder="Anzahl Liegeplätze"
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
			<MyButton css="btn btn-sm btn-outline-primary" icon="far fa-circle-xmark" name="btnClose"
					  @click.prevent="$emit('closeCalcForm', false)">Schliessen
			</MyButton>
		</BerthsCalculationForm>
	</div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import MyInput from "v@/components/form/berthsCalculation/elements/MyInput";
import MyCheckbox from "v@/components/form/berthsCalculation/elements/MyCheckbox";
import MyInputNumber from "v@/components/form/berthsCalculation/elements/MyInputNumber";
import BerthsCalculationForm from "v@/components/form/berthsCalculation/BerthsCalculationForm";
import MySelect from "v@/components/form/berthsCalculation/elements/MySelect";
import MyButton from "v@/components/form/MyButton";
import MyRadio from "v@/components/form/berthsCalculation/elements/MyRadio";

export default {
	name: "FormCalculateBerths",
	components: {MyRadio, MyButton, MySelect, BerthsCalculationForm, MyInput, MyInputNumber, MyCheckbox},
	data() {
		return {
			optionsModus: [
				{id: null, name: 'Zählart wählen'},
				{id: 'even', name: 'gerade'},
				{id: 'odd', name: 'ungerade'},
			],
		}
	},
	computed: {
		...mapGetters({
			calcData: "berth/calcData",
			docksOptions: "berth/docksOptions",
			categories: "berth/categories",
		}),
	},
	methods: {
		onChange(e) {
			if ("dock_id" === e.target.name) {
				this.selectDock({
					id: e.target.value,
					name: e.target.innerText,
				});
			}
			this.setCalcData({...this.calcData, [e.target.name]: e.target.value});
		},
		close() {
			this.$emit('closeCalcForm')
		},
		...mapActions({
			setCalcData: "berth/setCalcData",
			selectDock: "berth/selectDock",
		}),
	}
}
</script>
