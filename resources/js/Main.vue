<template>
	<div class="m-5">
		<h1 class="my-3 text-2xl text-blue-900">Main Component</h1>
		<slot/>
	</div>
</template>

<script>
export default {
	name: "Main",
	props: ['view']
}
</script>

<style scoped>
</style>
