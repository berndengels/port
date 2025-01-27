<template>
	<div class="mb-5">
		<h5>Liegeplatz {{ selected.number ?? '' }}</h5>
		<form class="frmMap m-3">
			<div class="form-check">
				<input
					type="checkbox"
					id="enabled"
					class="form-check-input"
					v-model="selected.enabled"
				/>
				<label class="form-check-label ms-2" for="enabled">Aktiv</label>
			</div>
			<div class="row">
				<label class="col-auto form-label" for="dock_id">Steg</label>
				<div class="col-5">
					<select
						id="dock_id"
						class="form-select form-select-sm d-inline-block"
						v-model="selected.dock_id"
					>
						<optgroup v-if="docks && docks.length > 0">
							<option
								v-for="item in docks"
								:key="item.id"
								:value="item.id"
							>{{ item.name }}
							</option>
						</optgroup>
					</select>
				</div>
			</div>
			<div class="row">
				<label class="col-auto form-label" for="berth_category_id">Kategorie</label>
				<div class="col-5">
					<select
						id="berth_category_id"
						class="form-select form-select-sm d-inline-block"
						v-model="selected.berth_category_id"
					>
						<optgroup v-if="categories && categories.length > 0">
							<option
								v-for="item in categories"
								:key="item.id"
								:value="item.id"
							>{{ item.name }}
							</option>
						</optgroup>
					</select>
				</div>
			</div>
			<div class="row">
				<label class="col-auto form-label" for="number">Nummer</label>
				<input class="col-auto form-input" type="number" id="number" v-model="selected.number" min="1" step="1"/>
			</div>

			<div class="row">
				<label class="col-auto form-label" for="width">Breite</label>
				<input class="col-auto form-input" type="number" id="width" v-model="selected.width" min="1" step="0.1"/>
			</div>
			<div class="row">
				<label class="col-auto form-label" for="number">Länge</label>
				<input class="col-auto form-input" type="number" id="length" v-model="selected.length" min="1" step="0.1"/>
			</div>
			<div class="row">
				<label class="col-auto form-label" for="number">Tagespreis</label>
				<input class="col-auto form-input" type="number" id="daily_price" v-model="selected.daily_price" min="1"
					   step="1"/>
			</div>
			<div class="mt-2">
				<form class="">
					<button type="button" class="btn btn-primary btn-sm" @click.prevent="save">
						Speichen
					</button>
					<button type="button" class="btn btn-danger btn-sm ms-2" @click.prevent="close">
						Schliessen
					</button>
				</form>
			</div>
		</form>
	</div>
</template>

<script>
import {mapGetters, mapActions} from "vuex";
import MyButton from "v@/components/form/MyButton";

export default {
	name: "EditBerth",
	components: {MyButton},
	computed: {
		...mapGetters({
			docks: "berth/docks",
			categories: "berth/categories",
			selected: "berth/selected",
			errors: "berth/errors",
			docksOptions: "berth/docksOptions",
		}),
	},
	methods: {
		save() {
			this.update(this.item);
		},
		close() {
			this.select(null)
		},
		...mapActions({
			update: "berth/update",
			select: "berth/select",
		}),
	}
}
</script>
