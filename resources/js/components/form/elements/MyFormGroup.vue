<template>
    <div class="mt-2">
        <label>
            <span v-if="inline">{{ label }}</span>
            <div v-else class="block"><span>{{ label }}</span></div>
            <div :class="{'inline': inline}">
                <slot :data="data"></slot>
            </div>
        </label>
        <MyFormErrors v-if="errors"/>
    </div>
</template>

<script>
import MyFormErrors from "./MyFormErrors";
export default {
    name: "MyFormGroup",
    components: {MyFormErrors},
    props: ['name', 'label' , 'type', 'errors', 'class', 'inline', 'data'],
    created() {
        console.info(this.$root.$props.data);
    },
}
</script>

<style scoped>
</style>
