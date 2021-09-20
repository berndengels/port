<template>
    <div class="grid-container">
        <div class="menu-icon" @click="onClick">
            <i class="fas fa-bars"></i>
        </div>
        <AdminHeader />
        <AdminSidebar />
        <AdminMain><slot name="main"></slot></AdminMain>
        <AdminFooter />
    </div>
</template>

<script>
import AdminHeader from "../Components/Navigation/AdminHeader";
import AdminSidebar from "../Components/Navigation/AdminSidebar";
import AdminMain from "../Components/AdminMain";
import AdminFooter from "../Components/AdminFooter";
import MyCss from "../Mixins/MyCss";

export default {
    name: 'AdminLayout',
    props: {
        title: String,
        mainCss: String,
    },
    mixins: [MyCss],
    components: {
        AdminHeader,
        AdminMain,
        AdminSidebar,
        AdminFooter,
    },
    methods: {
        onClick() {
            let sideNav = document.querySelector('.sidenav');
            this.addClass(sideNav,'active')
        },
    },
}
</script>
