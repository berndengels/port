<template>
    <DefaultLayout fullscreen="true">
        <div class="flex-container">
            <div class="flex-item">
                <h5>Wohnwagen zur Zeit: {{currentCaravans.length}}</h5>
                <div v-if="currentCaravans.length > 0" class="flex-container">
                    <div v-for="car in currentCaravans" :key="car.id" class="flex flex-wrap flex-shrink-0 carnumber">
                        {{ car.carnumber }}
                    </div>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script>
    import DefaultLayout from "../Layouts/DefaultLayout";
    var isBetween = require('dayjs/plugin/isBetween')
    dayjs.extend(isBetween)

    export default {
        name: "Dashboard",
        components: {
            DefaultLayout,
        },
        data() {
            return {
                caravans: this.$page.props.caravan.dates.list
            }
        },
        computed: {
            currentCaravans() {
                return this.caravans.filter(car => dayjs().isBetween(car.from, car.until, null, '[]'))
            }
        }
    }
</script>

<style scoped>
    ul {
        list-style: none;
    }
    li {
        list-style: none;
    }
</style>
