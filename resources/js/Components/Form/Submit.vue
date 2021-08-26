<template>
    <div>
        <Button type="submit" :label="label" :name="name" :css="css" />
    </div>
</template>

<script>
import Button from "@/Components/Form/Button";

export default {
    name: "Submit",
    components: { Button },
    props: {
        name: String,
        label: String,
        css: String,
        type: {
            type: String,
            default: 'button',
        }
    }
}
</script>

<style scoped>
</style>
