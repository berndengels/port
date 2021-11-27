<template>
    <div class="mt-2">
        <label>
            <span v-if="inline">{{ label }}</span>
            <div v-else class="block"><span>{{ label }}</span></div>
            <div :class="{'inline': inline}">
                <input :type="type ?? 'text'"
                       :name="name"
                       :class="css"
                       :placeholder="placeholder"
                       v-model="data[name]"
                />
            </div>
            <div v-if="message" class="w-full error text-red-500 text-xs italic py-2">
                {{ message }}
            </div>
        </label>
    </div>
</template>

<script>
import { mapGetters } from "vuex"

export default {
    name: "MyInput",
    props: ['name', 'label', 'type', 'css', 'inline', 'placeholder'],
    data() {
        return {
            data: this.$parent.$props.data ?? null,
        }
    },
    computed: {
        ...mapGetters({errors: "caravan/errors"}),
        message() {
            console.info(this.errors)
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
