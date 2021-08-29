<template>
    <DefaultLayout fullscreen="true">
        <div class="flex-container">
            <div class="flex-item">
                <h5>Wohnwagen zur Zeit: {{currentCaravans.length}}</h5>
                <ul v-if="currentCaravans.length > 0">
                    <li v-for="car in currentCaravans" :key="car.id">{{ car.carnumber }}</li>
                </ul>
            </div>
            <!--div class="flex-item">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Explanetur igitur. Consequentia exquirere, quoad sit id, quod volumus, effectum. Duo Reges: constructio interrete.</p>
            </div-->
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
