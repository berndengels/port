<template>
    <div class="mt-2">
        <label>
            <span v-if="inline">{{ label }}</span>
            <div v-else class="block"><span>{{ label }}</span></div>
            <div :class="{'inline': inline}">
                <input v-if="data && undefined !== data[name]"
                       type="checkbox"
                       :id="id ?? name"
                       :name="name"
                       :class="css"
                       :value="data[name]"
                       :checked="data[name]"
                       @change="handleChange"
                />
                <input v-else
                       type="checkbox"
                       :id="id ?? name"
                       :name="name"
                       :class="css"
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
