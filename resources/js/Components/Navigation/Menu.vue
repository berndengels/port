<template>
    <div>
        <ul v-if="menuItems">
            <li v-for="(item,routeName) of $page.props.currentMenu" :key="routeName">
                <NavLink :href="route(routeName)">
                    <i v-if="item.icon" :class="item.icon"></i>
                    {{ item.text }}
                </NavLink>
            </li>
        </ul>
        <h3 v-else>No menuItems</h3>
    </div>
</template>

<script>
import NavLink from "../../Jetstream/NavLink";
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "Menu",
    components: {NavLink},
    watch: {
        'menuItems': (newVal, oldVal) => {
            console.info(newVal)
        },
    },
    computed: {
        menuItems() {
            return this.$page.props.currentMenu
        }
    },
}
</script>

<style scoped>
</style>
