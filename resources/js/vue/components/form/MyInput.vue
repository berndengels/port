<template>
	<div>
		<div v-if="floating" class="form-floating mt-2">
			<div :class="{'inline': inline}">
				<input v-if="data && undefined !== data[name]" :type="type ?? 'text'"
					   :id="id ?? name"
					   :name="name"
					   :class="'form-control ' + css"
					   :value="data[name]"
					   @change="handleChange"
				/>
				<input v-else :type="type ?? 'text'"
					   :id="id ?? name"
					   :name="name"
					   :class="'form-control ' + css"
					   @change="handleChange"
				/>
			</div>
			<MyFormErrors v-if="errors" :errors="errors" :name="name" />
			<label v-if="floating || inline" class="form-label">
				<span v-if="inline">{{ label }}</span>
				<div v-else class="block"><span>{{ label }}</span></div>
			</label>
		</div>
		<div v-else class="mt-2">
			<label class="form-label">
				<span v-if="inline">{{ label }}</span>
				<div v-else class="block"><span>{{ label }}</span></div>
				<div :class="{'inline': inline}">
					<input v-if="data && undefined !== data[name]" :type="type ?? 'text'"
						   :id="id ?? name"
						   :name="name"
						   :class="'form-control ' + css"
						   :placeholder="placeholder ?? label"
						   :value="data[name]"
						   @change="handleChange"
					/>
					<input v-else :type="type ?? 'text'"
						   :id="id ?? name"
						   :name="name"
						   :class="'form-control ' + css"
						   :placeholder="placeholder ?? label"
						   @change="handleChange"
					/>
				</div>
				<MyFormErrors v-if="errors" :errors="errors" :name="name" />
			</label>
		</div>
	</div>
</template>

<script>
import MyFormErrors from "v@/components/form/MyFormErrors";

export default {
    name: "MyInput",
    components: [MyFormErrors],
    props: ['name', 'id', 'label', 'type', 'css', 'inline', 'placeholder', 'floating'],
    data() {
        return {
            data: this.$parent.$props.data ?? null,
            errors: this.$parent.$props.errors ?? null,
        }
    },
    computed: {
        message() {
            if(this.errors && undefined !== this.errors[this.name]) {
                return this.errors[this.name][0]
            }
            return null
        }
    },
}
</script>

<style scoped>
</style>
