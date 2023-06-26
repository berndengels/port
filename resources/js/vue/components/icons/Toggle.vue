<template>
	<i :class="css" @click="toggle(item)"></i>
</template>

<script>
import {mapActions} from "vuex";

const prefix = "d-inline-block fs-5 lh-md fas",
	on = " green fa-check-circle on",
	off = " red fa-times off";

export default {
	name: "Toggle",
	props: ['item', 'field'],
	data() {
		return {
			css: prefix + (this.item[this.field] ? on : off)
		}
	},
	methods: {
		toggle(item) {
			let data = {...item, [this.field]: !item[this.field]};
			this.update(data);
			this.css = prefix + (!item[this.field] ? on : off)
		},
		...mapActions({
			update: "berth/update",
		}),
	}
}
</script>

<style scoped>
i {
	cursor: pointer;
}
</style>
