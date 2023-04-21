<template>
    <div class="d-inline-block">
        <input v-if="data && undefined !== data[name]"
               type="radio"
               class="form-check-input"
               :id="id ?? name"
               :name="name"
               :value="value ?? null"
               :checked="value === data[name]"
        />
        <input v-else
               type="radio"
               class="form-check-input"
               :id="id ?? name"
               :name="name"
               :value="value ?? null"
        />
        <label class="form-check-label ms-1" :for="id ?? name">{{ label }}</label>
    </div>
</template>

<script>
import MyFormErrors from "v@/components/form/MyFormErrors";

export default {
    name: "MyRadio",
    components: [MyFormErrors],
    props: ['id', 'name', 'label', 'value'],
    data() {
        return {
            data: this.$parent.$props.data ?? null,
            errors: this.$parent.$props.errors ?? null,
        }
    },
    computed: {
        message() {
            if(this.errors && undefined !== this.errors[this.name]) {
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
