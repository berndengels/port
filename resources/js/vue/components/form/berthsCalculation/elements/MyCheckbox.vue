<template>
	<div class="form-check mb-2">
		<input v-if="data && undefined !== data[name]"
			   type="checkbox"
			   :id="id ?? name"
			   :name="name"
			   class="form-check-input"
			   :value="data[name]"
			   :checked="data[name]"
		/>
		<input v-else
			   type="checkbox"
			   :id="id ?? name"
			   :name="name"
			   class="form-check-input"
		/>
		<label class="form-check-label" :for="id ?? name">{{ label }}</label>
		<MyFormErrors v-if="errors" :errors="errors" :name="name"/>
	</div>
</template>

<script>
import MyFormErrors from "v@/components/form/MyFormErrors";

export default {
	name: "MyCheckbox",
	components: [MyFormErrors],
	props: ['id', 'name', 'label', 'css', 'inline'],
	data() {
		return {
			data: this.$parent.$props.data ?? null,
			errors: this.$parent.$props.errors ?? null,
		}
	},
	computed: {
		message() {
			if (this.errors && undefined !== this.errors[this.name]) {
				console.info("errors", this.errors);
				return this.errors[this.name][0]
			}
			return null
		}
	},
}
</script>

<style scoped>
</style>
