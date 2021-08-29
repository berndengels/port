<template>
    <div class="md:flex md:items-center mb-6">
        <Label :for="name" :text="label" />
        <div class="md:w-2/3">
            <select
                :id="name"
                :name="name"
                :required="required"
                v-model="$parent.$props.data[name]"
                class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
            >
                <option
                    v-for="(val, index) in options"
                    :key="index"
                    :value="index"
                    >
                    {{ val }}
                </option>
            </select>
            <ValidationFieldErrors :field="name" v-if="handleErrors" />
        </div>
    </div>
</template>

<script>
import Label from "@/Components/Form/Label";
import ValidationFieldErrors from "@/Components/Form/ValidationFieldErrors";

export default {
    name: "Select",
    components: {ValidationFieldErrors, Label },
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
        handleErrors: {
            type: Boolean,
            default: false,
        },
    }
}
</script>

<style scoped>
</style>
