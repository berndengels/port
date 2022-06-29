<template>
    <button v-if="inline" :class="css ?? 'btn inline'" :name="name" :id="id ?? name">
        <slot>Click</slot>
    </button>
    <div v-else class="mt-2">
        <button :class="css ?? 'btn'" :name="name" :id="id ?? name">
            <slot>Click</slot>
        </button>
    </div>
</template>

<script>
export default {
    name: "MyButton",
    props: ['name', 'id', 'css', 'type', 'inline'],
}
</script>

<style scoped>
</style>
