<template>
    <header class="header">
        <!--div class="header__search">Search...</div-->
        <!--div class="header__avatar">Your face</div-->
        <Menu />
    </header>
</template>

<script>

import Menu from "./Menu";
export default {
    name: "AdminHeader",
    components: {Menu}
}
</script>

<style scoped>
</style>
