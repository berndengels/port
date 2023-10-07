<template>
	<div class="m-5">
		<div>
			<CustomerCraneDatesCardCalendar title="Kran-Termine" cranable-type="cranableType"/>
		</div>
	</div>
</template>

<script>
import CustomerCraneDatesCardCalendar from "v@/components/CustomerCraneDatesCardCalendar.vue";

export default {
	name: "CraneDates",
	components: {CustomerCraneDatesCardCalendar},
	beforeCreate() {
		this.$store.dispatch("craneDates/all");
	},
}
</script>
