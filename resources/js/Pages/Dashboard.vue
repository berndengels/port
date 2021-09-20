<template>
    <AdminLayout>
        <template #main>
            <div class="main-header">Dashboard</div>
            <div class="main-cards">
                <div v-if="$page.props.auth.user" class="card">
                    <div>
                        <h5 v-if="0 === countCurrentCaravans">zur Zeit sind keine Wohnmobile hier</h5>
                        <h5 v-else-if="1 === countCurrentCaravans">zur Zeit ist 1 Wohnmobil hier</h5>
                        <h5 v-else>zur Zeit sind {{countCurrentCaravans}} Wohnmobile hier</h5>
                        <div v-if="countCurrentCaravans > 0" class="flex-container">
                            <div v-for="car in currentCaravans" :key="car.id" class="flex flex-wrap flex-shrink-0 carnumber">
                                {{ car.carnumber }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AdminLayout>
</template>

<script>
    import DefaultLayout from "../Layouts/DefaultLayout";
    import AdminLayout from "../Layouts/AdminLayout";

    var isBetween = require('dayjs/plugin/isBetween')
    dayjs.extend(isBetween)

    export default {
        name: "Dashboard",
        components: {
            AdminLayout,
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
            },
            countCurrentCaravans() {
                return this.currentCaravans.length
            }
        },
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
