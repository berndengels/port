<template>
	<div class="card align-self-center calendar">
		<div class="card-header">
			<strong v-html="title"></strong>
		</div>
		<div v-if="loading" class="card-body p-3 loader-wrapper">
			<pulse-loader color="#394263" size="20px"/>
		</div>
		<div v-else class="card-body p-3">
			<div class="row">
				<div class="col">
					<FullCalendar ref="fullCalendar" :options="calendarOptions"/>
				</div>
				<div class="col">
					<div v-if="this.selectedDate">
						<!--MyForm :data="craneDate" :errors="errors" class="w-100">
							<MySelect floating="true" :options="cranableTypeOptions" label="Art" name="cranable_type" @change="onChange"/>
							<MySelect floating="true" v-if="boats" :options="boats" label="Boot" name="cranable_id"/>
							<MyInput floating="true" label="Datum" name="crane_date" type="date"/>
							<MyInput floating="true" label="Uhrzeit" name="crane_time" type="time"/>
						</MyForm-->
						<form class="mt-5" @submit.prevent>
							<div class="form-floating">
								<select id="cranable_type" name="cranable_type" class="form-select" @change="onChange">
									<option v-for="item in cranableTypeOptions" :key="item.id" :value="item.id">{{ item.name }}</option>
								</select>
								<label for="cranable_type">Art</label>
							</div>
							<div v-if="boats" class="form-floating mt-2">
								<select id="cranable_id" name="cranable_id" class="form-select">
									<option value="">--Boot wählen--</option>
									<option v-for="item in boats" :key="item.id" :value="item.id">{{ item.name }}</option>
								</select>
								<label for="cranable_id">Boot</label>
							</div>
							<div class="form-floating mt-2">
								<input id="crane_date" name="crane_date" type="date" class="form-control" />
								<label for="crane_date">Datum</label>
							</div>
							<div class="form-floating mt-2">
								<input id="crane_time" name="crane_time" type="time" class="form-control" />
								<label for="crane_time">Uhrzeit</label>
							</div>
							<div v-if="boats" class="form-floating mt-2">
								<button role="button" class="btn btn-sm btn-primary" @click="onSubmit">Speichen</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { ref, reactive } from "vue";
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timegridGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import multiMonthPlugin from '@fullcalendar/multimonth'
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import MyForm from "v@/components/form/MyForm.vue";
import MySelect from "v@/components/form/MySelect.vue";
import MyInput from "v@/components/form/MyInput.vue";

const calendar = ref(null);
export default {
	name: "CraneDatesCardCalendar",
	components: {MyInput, MySelect, MyForm, FullCalendar, PulseLoader},
	props: {
		title: String,
	},
	data() {
		return {
			loading: true,
			calendarApi: null,
			selectedDate: null,
			craneDate: {
				id: null,
				start: null,
				end: null,
			},
			calendarOptions: reactive({
				plugins: [dayGridPlugin, timegridGridPlugin, interactionPlugin, multiMonthPlugin],
				navLinks: true,
				selectable: true,
				themeSystem: 'bootstrap5',
				headerToolbar: {
					left: 'dayGridYear, dayGridMonth, timeGridWeek, timeGridDay',
					center: 'title',
					right: 'prev, next',
				},
				businessHours: {
					// days of week. an array of zero-based day of week integers (0=Sunday)
					daysOfWeek: [ 1, 2, 3, 4 , 5, 6, 7], // Monday - Thursday
					startTime: '09:00', // a start time (10am in this example)
					endTime: '18:00', // an end time (6pm in this example)
				},
				views: {
					multiMonthFourMonth: {
						type: 'multiMonth',
						duration: { months: 1 }
					}
				},
				dateClick: this.selectDate,
				eventClick: this.onEventClick,
				initialView: 'dayGridMonth',
//				editable: true,
//				startEditable: true,
//				durationEditable: true,

//				initialView: 'timeGridWeek',
				contentWidth: '600px',
				contentHeight: '600px',
				locale: 'de',
				firstDay: 1,
				displayEventTime: true,
				events: [],
			}),
		}
	},
	computed: {
		dates() {
			console.info("dates", this.$store.state.craneDates.dates)
			return this.$store.state.craneDates.dates;
		},
		boats() {
			return this.$store.state.craneDates.boats;
		},
		cranableTypeOptions() {
			return this.$store.state.craneDates.cranableTypeOptions;
		},
		errors() {
			return this.$store.state.craneDates.errors;
		},
	},
	methods: {
//        ...mapActions({getBoats: 'craneDates/getBoats'}),

		selectDate: function (arg) {
			console.info("arg", arg);
			this.selectedDate = arg.dateStr;
//			this.craneDate.crane_date = arg.dateStr;
		},
		onEventClick: (e) => {
			console.info(e.event.extendedProps);
		},
		onChange(e) {
			let $el = $(e.target);
			if ('cranable_type' === $el.attr('name')) {
				this.$store.dispatch("craneDates/getBoats", $el.val());
			}
		},
		onSubmit() {

		},
		close() {
		},
	},
	created() {
	},
	mounted() {
		setTimeout(() => {
			this.calendarOptions.events = this.dates;
			this.loading = false;
		}, 500)
//		this.options.events = this.dates;

//		this.calendarApi = this.$refs ? this.$refs.fullCalendar.getApi() : null;
	}
}
</script>
