<template>
    <div v-if="inline" class="d-inline-block float-start me-2">
        <button :class="css ?? 'btn'" :name="name" :id="id ?? name">
            <slot>Click</slot>
        </button>
    </div>
    <div v-else class="mt-2">
        <button :class="css ?? 'btn'" :name="name" :id="id ?? name">
            <i v-if="icon" :class="icon"></i>
            <span :class="icon ? 'ms-1':''"><slot>Click</slot></span>
        </button>
    </div>
</template>

<script>
export default {
    name: "MyButton",
    props: ['name', 'id', 'css', 'type', 'inline', 'icon'],
}
</script>

<style scoped>
</style>
