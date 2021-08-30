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
                <!--ul v-if="items.length > 0" @click="$emit('onSelect', $event.target.value)" class="autocomplete"-->
                <ul @click="select" class="autocomplete">
                    <li v-for="item in items" :key="item[key]">{{item[name]}}</li>
                </ul>
                <ValidationFieldErrors :field="name" />
            </div>
        </div>
    </div>
</template>

<script>
import Label from "@/Components/Form/Label";
import ValidationFieldErrors from "@/Components/Form/ValidationFieldErrors";

export default {
    name: "Autocomplete",
    components: {Label, ValidationFieldErrors},
    props: ['data','name','key','label','autocomplete','required'],
    emits: ['onSelect'],
    data() {
        return {
            items: [],
            elAutoselect: null,
        }
    },
    mounted() {
        this.elAutoselect = document.querySelector('ul.autocomplete')
    },
    methods: {
        onInput(e) {
            if(e.target.value.length > 0) {
                this.items = this.data.filter(item => item[this.name].indexOf(e.target.value.toUpperCase()) === 0);
                this.elAutoselect.style.display = "block"
            } else {
                this.elAutoselect.style.display = "none"
                this.$parent.$props.data.reset()
            }
        },
        select(e) {
            this.$emit('onSelect', e)
            this.elAutoselect.style.display = "none"
        }
    }
}
</script>

<style scoped>
ul.autocomplete {
    display: none;
    position: absolute;
    width: auto;
    list-style: none;
    margin: 0;
    background-color: #fff;
    border: 1px solid #ccc;
    border-bottom-radius: 10px;
}
ul li {
    list-style: none;
    margin: 0.1 0.2rem;
    padding: 0.1rem 2.0rem;
    font-size: 0.9rem;
    cursor: pointer;
}
</style>
