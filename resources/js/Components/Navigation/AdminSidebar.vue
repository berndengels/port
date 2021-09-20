<template>
    <aside class="sidenav">
        <div class="sidenav__close-icon" @click="onClick">
            <i class="fas fa-times"></i>
        </div>
        <ul class="sidenav__list">
            <li class="sidenav__list-item">
                <MyLink no-inertia="true" @click="setTopMenu('caravans')">Caravans</MyLink>
            </li>
            <li class="sidenav__list-item">
                <MyLink no-inertia="true" @click="setTopMenu('boote')">Boote</MyLink>
            </li>
        </ul>
    </aside>
</template>

<script>
import MyLink from "../Form/MyLink";
import MyCss from "../../Mixins/MyCss";
import emitter from 'tiny-emitter/instance'

export default {
    name: "AdminSidebar",
    components: {MyLink},
    mixins: [MyCss],
    methods: {
        onClick() {
            let sideNav = document.querySelector('.sidenav');
            this.removeClass(sideNav,'active')
        },
        setTopMenu(route) {
            emitter.emit('menu', this.$page.props.menu.admin[route])
        }
    }
}
</script>

<style scoped>
</style>
