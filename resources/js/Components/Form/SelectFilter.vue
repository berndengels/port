<template>
    <div class="inline-flex md:items-center mb-6 left-0" :class="css">
        <Label :for="name" :text="label" css="inline-flex" />
        <div class="inline-flex ml-3">
            <select
                :id="name"
                :name="name"
                :keyName="keyName"
                :field="field"
                v-model="$parent.$props.data[name]"
                @change="$emit('selected' + ucFirst(name), $event.target.value)"
                class="inline-flex bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
            >
                <!--option value="">wählen</option-->
                <option
                    v-for="(item, index) in options"
                    :key="index"
                    :value="keyName ? item[keyName] :  index"
                >
                    {{ field ? item[field] : item }}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
import Label from "@/Components/Form/Label";
import MyString from "../../Mixins/MyString";

export default {
    name: "SelectFilter",
    components: {Label},
    mixins: [MyString],
    data() {
        return {
            data: this.$parent.$props.data[this.name] ?? null,
        }
    },
    props: {
        options: Array,
        name: String,
        keyName: {
            type: String,
            default: null,
        },
        field: {
            type: String,
            default: null,
        },
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
