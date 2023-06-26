<template>
	<form class="mt-5" @submit.prevent>
		<input id="id" v-model="craneDate.id" class="form-control" name="id" type="hidden"/>
		<div class="form-floating">
			<select id="cranable_type" v-model="craneDate.cranable_type" class="form-select"
			        @change="getBoats(craneDate.cranable_type)">
				<option v-for="item in cranableTypeOptions" :key="item.id" :value="item.id">
					{{ item.name }}
				</option>
			</select>
			<label for="cranable_type">Art</label>
		</div>
		<div class="form-floating mt-2">
			<select id="cranable_id" v-model="craneDate.cranable_id" class="form-select">
				<option value="">--Boot wählen--</option>
				<option v-for="item in boats" :key="item.id" :value="item.id">{{
						item.name
					}}
				</option>
			</select>
			<label for="cranable_id">Boot</label>
		</div>
		<div class="form-floating mt-2">
			<input id="crane_date" v-model="craneDate.crane_date" class="form-control" type="date"/>
			<label for="crane_date">Datum</label>
		</div>
		<div class="form-floating mt-2">
			<input id="crane_time" v-model="craneDate.crane_time" class="form-control" max="21:00"
			       min="08:00"
			       type="time"/>
			<label for="crane_time">Uhrzeit</label>
		</div>
		<div v-if="boats" class="form-floating mt-2">
			<button class="btn btn-sm btn-primary" role="button" @click="handleStore(craneDate)">Speichen</button>
		</div>
	</form>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
	name: "CreateForm",
	data() {
		return {
			createCraneDate: {
				id: null,
				cranable_type: null,
				cranable_id: null,
				crane_date: null,
				crane_time: null
			},
		}
	}
})
</script>

<style scoped>

</style>