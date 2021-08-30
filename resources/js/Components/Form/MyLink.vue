<template>
    <div class="btn-wrapper md:flex md:items-center" :class="classes">
        <a v-if="noInertia" :href="href" class="rounded btn" :class="ctrClass" :title="title" :target="_blank">
            <i v-if="icon" :class="icon"></i>
            <slot />
        </a>
        <NavLink v-if="role === 'button' && !noInertia" class="rounded btn" :class="ctrClass" :title="title">
            <i v-if="icon" :class="icon"></i>
            <span><slot /></span>
        </NavLink>
        <NavLink v-else-if="!noInertia" :href="href" class="rounded btn" :class="ctrClass" :title="title">
            <i v-if="icon" :class="icon"></i>
            <span><slot /></span>
        </NavLink>
    </div>
</template>

<script>
import NavLink from "../../Jetstream/NavLink";
export default {
    name: "MyLink",
    components: {NavLink},
    props: {
        noInertia: Boolean,
        target: String,
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
        active: Boolean,
    },
    computed: {
        classes() {
            return this.active ? 'bg-red' : ''
        }
    }
}
</script>

<style scoped>
</style>
