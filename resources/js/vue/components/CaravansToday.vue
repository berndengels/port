<template>
    <div v-if="caravans" class="flex-item-dashboard p-3 widget">
        <div class="title">Wohnmobile heute:</div>
        <div v-for="(item,index) in caravans" :key="index" class="content carnumber">
            {{ item }}
        </div>
    </div>
</template>

<script>

export default {
    name: "CaravansToday",
    props: ['caravans']
}
</script>

<style scoped>
</style>
