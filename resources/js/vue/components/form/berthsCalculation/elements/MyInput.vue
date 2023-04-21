<template>
    <div class="mt-2 row">
        <label :for="id ?? name" class="col-sm-2 col-form-label col-form-label-sm">{{ label }}</label>
        <div class="col-sm-10 col-lg-4">
            <input v-if="data && undefined !== data[name]" :type="type ?? 'text'"
                   :id="id ?? name"
                   :name="name"
                   :placeholder="placeholder ?? label"
                   :value="data[name]"
                   class="form-control form-control-sm form-input ps-1"
            />
            <input v-else :type="type ?? 'text'"
                   :id="id ?? name"
                   :name="name"
                   :placeholder="placeholder ?? label"
                   class="form-control form-control-sm form-input ps-1"
            />
        </div>
        <MyFormErrors v-if="errors" :errors="errors" :name="name" />
    </div>
</template>

<script>
import MyFormErrors from "v@/components/form/MyFormErrors";

export default {
    name: "MyInput",
    components: [MyFormErrors],
    props: ['name', 'id', 'label', 'type', 'css', 'inline', 'placeholder'],
    data() {
        return {
            data: this.$parent.$props.data ?? null,
            errors: this.$parent.$props.errors ?? null,
        }
    },
    computed: {
        message() {
            console.info("errors", this.errors);
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
