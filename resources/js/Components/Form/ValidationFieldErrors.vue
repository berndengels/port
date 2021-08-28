<template>
    <div v-if="hasErrors" class="clear-both">
        <div class="font-medium text-red-600">
            <span class="mt-3 text-sm text-red-600">{{ error }}</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "ValidationFieldErrors",
    props: {
        field: String,
    },
    computed: {
        error() {
            return (undefined !== this.$page.props.errors && undefined !== this.$page.props.errors[this.field]) ? this.$page.props.errors[this.field] : null
        },
        hasErrors() {
            return !!this.error;
        },
    }
}
</script>
