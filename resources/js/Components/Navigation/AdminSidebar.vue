<template>
    <aside class="sidenav">
        <div class="sidenav__close-icon" @click="onClick">
            <i class="fas fa-times"></i>
        </div>
        <ul class="sidenav__list">
            <li class="sidenav__list-item">
                <MyLink :no-inertia="true" @click="setTopMenu('caravans')">Caravans</MyLink>
            </li>
            <li class="sidenav__list-item">
                <MyLink :no-inertia="true" @click="setTopMenu('boote')">Boote</MyLink>
            </li>
        </ul>
    </aside>
</template>

<script>
import MyLink from "../Form/MyLink";
import MyCss from "../../Mixins/MyCss";
import emitter from 'tiny-emitter/instance'
import axios from "axios";
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "AdminSidebar",
    components: {MyLink},
    mixins: [MyCss],
    methods: {
        onClick() {
            let sideNav = document.querySelector('.sidenav');
            this.removeClass(sideNav,'active')
        },
        setTopMenu(routeName) {
            axios.post(route('route.current'), {current: this.$page.props.menu.admin[routeName]})
                .then(resp => {
                    document.addEventListener('menu:update', (event, data) => {
                        data = resp.data
                        console.log(`Starting a visit to ${event.detail.visit.url}`)
                    })
                })
                .catch(err=>console.error(err))
            ;
//            emitter.emit('menu', this.$page.props.menu.admin[routeName])
        }
    }
}
</script>

<style scoped>
</style>
