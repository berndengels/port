<template>
    <div class="mt-2">
        <button class="btn" :name="name" :type="type ?? 'submit'">
            <slot>Click</slot>
        </button>
    </div>
</template>

<script>
export default {
    name: "MyButton",
    props: ['name', 'type', 'inline'],
}
</script>

<style scoped>
</style>
