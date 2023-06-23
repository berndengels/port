<template>
	<div class="mb-2 row">
		<label :for="id ?? name">{{ label }}</label>
		<div class="col-sm-10 col-lg-4">
			<input v-if="data && undefined !== data[name]" type="number"
				   :id="id ?? name"
				   :name="name"
				   :placeholder="placeholder ?? label"
				   :min="min ?? 1"
				   :max="max ?? 10000000"
				   :step="step ?? 1"
				   :value="data[name]"
				   class="form-control form-control-sm form-input ps-1"
			/>
			<input v-else type="number"
				   :id="id ?? name"
				   :name="name"
				   :placeholder="placeholder ?? label"
				   :min="min ?? 1"
				   :max="max ?? 10000000"
				   :step="step ?? 1"
				   class="form-control form-control-sm form-input ps-1"
			/>
		</div>
		<MyFormErrors v-if="errors" :errors="errors" :name="name"/>
	</div>
</template>

<script>
import MyFormErrors from "v@/components/form/MyFormErrors";

export default {
	name: "MyInputNumber",
	components: [MyFormErrors],
	props: ['name', 'id', 'label', 'css', 'inline', 'placeholder', 'min', 'max', 'step'],
	data() {
		return {
			data: this.$parent.$props.data ?? null,
			errors: this.$parent.$props.errors ?? null,
		}
	},
	computed: {
		message() {
			console.info(this.errors);
			if (this.errors && undefined !== this.errors[this.name]) {
				return this.errors[this.name][0]
			}
			return null
		}
	},
}
</script>

<style scoped>
</style>
