<template>
    <div class="m-5">
        <div>
            <CraneDatesCardCalendar title="Kran-Termine" />
        </div>
    </div>
</template>

<script>
import CraneDatesCardCalendar from "v@/components/CraneDatesCardCalendar.vue";

export default {
    name: "CraneDates",
    components: {CraneDatesCardCalendar},
    beforeCreate() {
        this.$store.dispatch("craneDates/all");
    },
}
</script>
