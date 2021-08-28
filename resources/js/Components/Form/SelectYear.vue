<template>
    <div class="inline-flex md:items-center mb-6 left-0" :class="css">
        <Label :for="name" :text="label" css="inline-flex" />
        <div class="inline-flex">
            <select
                :id="name"
                :name="name"
                v-model="$parent.$props.data[name]"
                @change="$emit('selectYear', $event.target.value)"
                class="inline-flex bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
            >
                <option
                    v-for="val in options"
                    :key="val"
                    :value="val"
                    >
                    {{ val }}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
import Label from "@/Components/Form/Label";

export default {
    name: "SelectYear",
    components: {Label},
    data() {
        return {
            data: this.$parent.$props.data[this.name] ?? null,
        }
    },
    props: {
        options: Array,
        name: String,
        label: {
            type: String,
            default: null,
        },
        css: String,
        required: {
            type: Boolean,
            default: false,
        },
    }
}
</script>

<style scoped>
</style>
