<template>
    <div class="md:flex md:items-center mb-6">
        <Label :for="name" :text="label" />
        <div class="md:w-2/3 inline-flex">
            <input
                type="checkbox"
                :id="name"
                :name="name"
                :required="required"
                v-model="$parent.$props.data[name]"
            />
            <ValidationFieldErrors :field="name" />
        </div>
    </div>
</template>

<script>
import Label from "../../Components/Form/Label";
import ValidationFieldErrors from "@/Components/Form/ValidationFieldErrors";

export default {
    name: "Checkbox",
    components: {Label, ValidationFieldErrors},
    props: {
        name: {
            type: String,
            required: true,
        },
        label: {
            type: String,
        },
        required: {
            type: Boolean,
            default: false,
        },
    },
}
</script>

<style scoped>
</style>
