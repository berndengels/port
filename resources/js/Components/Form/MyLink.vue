<template>
    <div>
        <div class="'md:flex md:items-center mb-6'" :class="css">
            <NavLink v-if="role === 'button'" class="rounded btn" :class="ctrClass" :title="title">
                <i v-if="icon" :class="icon"></i>
                <span><slot /></span>
            </NavLink>
            <NavLink v-else :href="href" class="rounded btn" :class="ctrClass" :title="title">
                <i v-if="icon" :class="icon"></i>
                <span><slot /></span>
            </NavLink>
        </div>
    </div>
</template>

<script>
import NavLink from "../../Jetstream/NavLink";
export default {
    name: "MyLink",
    components: {NavLink},
    props: {
        role: {
            type: String,
            default: "link",
        },
        href: {
            type: String,
            default: null,
        },
        icon: String,
        title: String,
        ctrClass: String,
    }
}
</script>

<style scoped>
</style>
