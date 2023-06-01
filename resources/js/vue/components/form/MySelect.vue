<template>
    <div class="mt-2">
        <label class="form-label">
            <span v-if="inline">{{ label }}</span>
            <div v-else class="block"><span>{{ label }}</span></div>
            <div :class="'form-group ' + {'inline': inline}">
                <select v-if="data && undefined !== data[name]"
                        :id="id ?? name"
                        :name="name"
                        :class="'form-select ' + css"
                        @change="handleChange"
                >
                    <optgroup v-if="options">
                        <option
                            v-for="item in options"
                            :key="item.id"
                            :value="item.id"
                            :selected="item.id === data[name]"
                        >{{ item.name }}</option>
                    </optgroup>
                </select>
                <select v-else
                        :id="id ?? name"
                        :name="name"
                        :class="'form-select ' + css"
                        @change="handleChange"
                >
                    <optgroup v-if="options">
                        <option
                            v-for="item in options"
                            :key="item.id"
                            :value="item.id"
                        >{{ item.name }}</option>
                    </optgroup>
                </select>
            </div>
            <MyFormErrors v-if="errors" :errors="errors" :name="name" />
        </label>
    </div>
</template>

<script>
import MyFormErrors from "v@/components/form/MyFormErrors";

export default {
    name: "MySelect",
    components: [MyFormErrors],
    props: ['id', 'name', 'options', 'label', 'css', 'inline'],
    data() {
        return {
            data: this.$parent.$props.data ?? null,
            errors: this.$parent.$props.errors ?? null,
        }
    },
    computed: {
        message() {
            if(this.errors && undefined !== this.errors[this.name]) {
                console.info("errors", this.errors);
                return this.errors[this.name][0]
            }
            return null
        }
    },
}
</script>

<style scoped>
</style>
