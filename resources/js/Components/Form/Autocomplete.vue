<template>
    <div>
        <div class="md:flex md:items-center mb-6">
            <Label :for="name" :text="label" />
            <div class="md:w-2/3">
                <input
                    type="text"
                    :id="name"
                    :name="name"
                    :autocomplete="autocomplete"
                    :required="required"
                    v-model="$parent.$props.data[name]"
                    @keyup="onInput"
                    class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                />
                <ValidationFieldErrors :field="name" />
            </div>
        </div>
        <ul v-if="items.length > 0" @click="$emit('onSelect', $event)" class="block w-3/4">
            <li v-for="item in items" :key="item[key]">{{item[name]}}</li>
        </ul>
    </div>
</template>

<script>
import Label from "@/Components/Form/Label";
import ValidationFieldErrors from "@/Components/Form/ValidationFieldErrors";

export default {
    name: "Autocomplete",
    components: {Label, ValidationFieldErrors},
    props: ['data','name','key','label','autocomplete','required'],
    data() {
        return {
            items: [],
        }
    },
    methods: {
        onInput(e) {
            this.items = this.data.filter(item => item[this.name].indexOf(e.target.value.toUpperCase()) === 0);
        },
    }
}
</script>

<style scoped>
ul {
    width: auto;
    list-style: none;
    margin: 0.2rem 0.2rem;
    background-color: #eee;
}
ul li {
    list-style: none;
    margin-left: 1.0rem;
    padding: 0.2rem 0.2rem;
    font-size: 0.9rem;
}
</style>
