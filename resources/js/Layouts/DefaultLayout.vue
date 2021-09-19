<template>
    <AppLayout :title="title" :main-css="mainCss">
        <template #header v-if="title">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{title}}</h2>
        </template>

        <div v-if="fullscreen" class="w-full h-full min-h-screen mt-0 p-0">
            <slot></slot>
        </div>
        <div v-else class="py-3 min-h-screen mt-0">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <slot></slot>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "./AppLayout";
export default {
    name: "DefaultLayout",
    components: {AppLayout},
    props: ['title','fullscreen','mainCss'],
}
</script>

<style scoped>
</style>
