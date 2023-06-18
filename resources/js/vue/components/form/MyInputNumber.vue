<template>
    <div class="mt-2">
        <label class="form-label">
            <span v-if="inline">{{ label }}</span>
            <div v-else class="block"><span>{{ label }}</span></div>
            <div :class="{'inline': inline}">
                <input v-if="data && undefined !== data[name]" type="number"
                       :id="id ?? name"
                       :name="name"
                       :class="'form-control ' + css"
                       :placeholder="placeholder ?? label"
                       :min="min ?? 1"
                       :max="max ?? 10000000"
                       :step="step ?? 1"
                       :value="data[name]"
                       @change="handleChange"
                />
                <input v-else type="number"
                       :id="id ?? name"
                       :name="name"
                       :class="'form-control ' + css"
                       :placeholder="placeholder ?? label"
                       :min="min ?? 1"
                       :max="max ?? 10000000"
                       :step="step ?? 1"
                       @change="handleChange"
                />
            </div>
            <MyFormErrors v-if="errors" :errors="errors" :name="name" />
        </label>
    </div>
</template>

<script>
import MyFormErrors from "v@/components/form/MyFormErrors";

export default {
    name: "MyInputNumber",
    components: [MyFormErrors],
    props: ['name', 'id', 'label', 'css', 'inline', 'placeholder', 'min', 'max', 'step', 'floating'],
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
