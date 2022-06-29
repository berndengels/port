<template>
    <div class="mt-2">
        <label>
            <span v-if="inline">{{ label }}</span>
            <div v-else class="block"><span>{{ label }}</span></div>
            <div :class="{'inline': inline}">
                <input v-if="data && undefined !== data[name]" :type="type ?? 'text'"
                       :id="id ?? name"
                       :name="name"
                       :class="css"
                       :placeholder="placeholder ?? label"
                       :value="data[name]"
                />
                <input v-else :type="type ?? 'text'"
                       :id="id ?? name"
                       :name="name"
                       :class="css"
                       :placeholder="placeholder ?? label"
                />
            </div>
            <MyFormErrors v-if="errors" :errors="errors" :name="name" />
        </label>
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
