<template>
    <div class="md:flex md:items-center mb-6">
        <Label :for="name" :text="label" />
        <div class="md:w-2/3">
            <input
                :type="type"
                :id="name"
                :name="name"
                :required="required"
                :autofocus="autofocus"
                :autocomplete="autocomplete"
                :aria-autocomplete="autocomplete"
                v-model="$parent.$props.data[name]"
                class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
            />
            <ValidationFieldErrors :field="name" />
        </div>
    </div>
</template>

<script>
import Label from "@/Components/Form/Label";
import ValidationFieldErrors from "@/Components/Form/ValidationFieldErrors";

export default {
    name: "Input",
    components: {ValidationFieldErrors, Label},
    props: {
        name: String,
        label: {
            type: String,
            default: null,
        },
        css: String,
        type: {
            type: String,
            default: 'text',
        },
        required: {
            type: Boolean,
            default: false,
        },
        autofocus: {
            type: Boolean,
            default: false,
        },
        autocomplete: {
            type: String,
            default: "off",
        },
    }
}
</script>

<style scoped>
</style>
