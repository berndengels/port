<template>
	<div class="mb-2">
		<label :for="id ?? name">{{ label }}</label>
		<select v-if="data && undefined !== data[name]"
				:name="name"
				:id="id ?? name"
				class="form-select form-select-sm w-auto"
				@change="handleChange"
		>
			<optgroup v-if="options && options.length > 0">
				<option
					v-for="item in options"
					:key="item.id"
					:value="item.id"
					:selected="item.id === data[name]"
				>{{ item.name }}
				</option>
			</optgroup>
		</select>
		<select v-else
				:id="id ?? name"
				:name="name"
				class="form-select form-select-sm"
				@change="handleChange"
		>
			<optgroup v-if="options && options.length > 0">
				<option
					v-for="item in options"
					:key="item.id"
					:value="item.id"
				>{{ item.name }}
				</option>
			</optgroup>
		</select>
		<MyFormErrors v-if="errors" :errors="errors" :name="name"/>
	</div>
</template>

<script>
import MyFormErrors from "v@/components/form/MyFormErrors";

export default {
	name: "MySelect",
	components: [MyFormErrors],
	props: ['id', 'name', 'label', 'css', 'inline', 'options'],
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
