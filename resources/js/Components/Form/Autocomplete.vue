<template>
    <div>
        <Input :id="name" type="text" class="mt-1 block" v-model="form[name]" required autofocus :autocomplete="name"
            @keyup="onInput"
        />
        <ul v-if="items.length > 0" @click="$emit('onSelect', $event.target)">
            <li v-for="item in items" :key="item[key]">{{item[name]}}</li>
        </ul>
    </div>
</template>

<script>
import Input from "@/Jetstream/Input";
import Label from "@/Jetstream/Label";

export default {
    name: "Autocomplete",
    components: {Label, Input},
    props: ['data','name','key','form'],
    data() {
        return {
            items: [],
        }
    },
    methods: {
        onInput(e) {
            this.items = this.data.filter(item => item[this.name].indexOf(e.target.value.toUpperCase()) !== -1);
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
    padding: 0.1rem 0.2rem;
    font-size: 0.8rem;
}
</style>
