<template>
    <div>
        <ul v-if="menuItems">
            <li v-for="(item,routeName) of menuItems" :key="routeName">
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
import emitter from 'tiny-emitter/instance'
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "Menu",
    components: {NavLink},
    data() {
        return {
            menuItems: [],
        }
    },
    created() {
        this.initMenu()
        console.info(this.menuItems)
    },
    computed: {
        menuData() {
            if(this.menuItems.length > 0) {
                Inertia.remember(this.menuItems,'menu-items')
            }
        }
    },
    methods: {
        initMenu() {
            emitter.on('menu', (items) => {
                this.menuItems = items
            })
        }
    }

}
</script>

<style scoped>
</style>
