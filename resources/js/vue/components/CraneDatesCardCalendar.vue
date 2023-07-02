<template>
	<div class="card m-0 p-0 align-self-center calendar">
		<div class="card-header">
			<strong v-html="title"></strong>
		</div>
		<!--div v-if="loading" class="card-body p-3 loader-wrapper">
			<pulse-loader color="#394263" size="20px"/>
		</div-->
		<div class="card-body p-sm-0 p-lg-3">
			<div class="row p-0">
				<div class="col-sm-12 col-lg-6 p-0">
					<FullCalendar ref="fullCalendar" :options="config" />
				</div>
				<div class="col-sm-12 col-lg-6 p-0">
					<div v-if="errors" class="bg-danger text-light">
						<ul>
							<li v-for="(err, key) in errors" :key="key">{{ err }}</li>
						</ul>
					</div>
					<div v-show="showForm">
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
									<option v-for="item in boats" :key="item.id" :value="item.id">{{ item.name }}</option>
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
								<div v-if="!craneDate.id">
									<button class="btn btn-sm btn-primary" role="button"
									        @click="handleStore(craneDate)">
										Anlegen
									</button>
								</div>
								<div v-else>
									<button class="btn btn-sm btn-primary" role="button"
									        @click="handleUpdate(craneDate)">
										Speichen
									</button>
									<button class="btn btn-sm btn-danger ms-3" role="button"
									        @click="handleDestroy(craneDate)">Löschen
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import FullCalendar from '@fullcalendar/vue3'
import deLocale from '@fullcalendar/core/locales/de'
import dayGridPlugin from '@fullcalendar/daygrid'
import timegridGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import multiMonthPlugin from '@fullcalendar/multimonth'
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

export default {
	name: "CraneDatesCardCalendar",
	components: { FullCalendar, PulseLoader },
	props: {
		title: String,
	},
	data() {
		return {
			selectedDate: null,
			showForm: false,
			craneDate: {
				id: null,
				cranable_type: null,
				cranable_id: null,
				crane_date: null,
				crane_time: null
			},
		}
	},
	computed: {
		api() {
			return this.$refs.fullCalendar.getApi()
		},
		...mapGetters({
			events: "craneDates/dates",
			boats: "craneDates/boats",
			cranableTypeOptions: "craneDates/cranableTypeOptions",
			errors: "craneDates/errors",
			loading: "craneDates/loading",
		}),
		config() {
			return {
//				...this.craneDate,
				...this.configOptions,
				...this.eventHandlers
			}
		},
		configOptions() {
			return {
				plugins: [dayGridPlugin, timegridGridPlugin, interactionPlugin, multiMonthPlugin],
				locale: deLocale,
				firstDay: 1,
				aspectRatio: 1,
				displayEventTime: true,
				initialView: 'dayGridMonth',
				eventTextColor: '#fff',
				eventBackgroundColor: '#060',
				eventDisplay: 'block',
				navLinks: true,
				dayMaxEvents: true,
				selectable: true,
				editable: true,
				selectMirror: true,
				droppable: true,
				weekends: true,
				eventDurationEditable: false,
				expandRows: true,
				contentHeight: '600px',
				headerToolbar: {
					left: 'prev, next, today',
					center: 'title',
					right: 'dayGridYear, dayGridMonth, timeGridDay',
				},
				businessHours: {
					// days of week. an array of zero-based day of week integers (0=Sunday)
					daysOfWeek: [1, 2, 3, 4, 5, 6, 7], // Monday - Thursday
					startTime: '09:00', // a start time (10am in this example)
					endTime: '18:00', // an end time (6pm in this example)
				},
				views: {
					multiMonthFourMonth: {
						type: 'multiMonth',
						duration: {months: 1}
					}
				},
				events: this.events,
			}
		},
		eventHandlers() {
			return {
				select: this.createDate,
				eventDragStart: this.onDragStart,
//				eventDragStop: this.onDragStop,
				eventDrop: this.onEventDrop,
				eventClick: this.onEventClick,
				navLinkDayClick: this.onNavClick,
				navLinkWeekClick: this.onNavClick,
				datesSet: this.handleNavChange,
			}
		}
	},
	methods: {
		...mapActions({
			getBoats: 'craneDates/getBoats',
			update: 'craneDates/update',
			store: 'craneDates/store',
			destroy: 'craneDates/destroy',
		}),
		createDate({start}) {
			this.selectedDate = moment(start).format('YYYY-MM-DD');
			this.craneDate = {
				id: null,
				cranable_type: null,
				cranable_id: null,
				crane_date: moment(start).format('YYYY-MM-DD'),
				crane_time: null
			};
			this.showForm = true;
		},
		handleNavChange({start, startStr, view}) {
//			this.showForm = false;
		},
		handleUpdate(data) {
			this.update(data);
			this.showForm = false;
		},
		handleStore(data) {
			this.store(data);
			this.showForm = false;
		},
		handleDestroy(data) {
			this.destroy(data);
			this.showForm = false;
		},
		onEventClick({event}) {
			const p = event.extendedProps;
			this.selectedDate = moment(event.start).format('YYYY-MM-DD');
			this.craneDate = {
				id: p.id,
				cranable_type: p.cranable_type,
				cranable_id: p.cranable_id,
				crane_date: moment(p.crane_date).format('YYYY-MM-DD'),
				crane_time: p.crane_time,
			};
			this.$store.dispatch("craneDates/getBoats", p.cranable_type);
			console.info("selectedDate", this.selectedDate);
			this.api.gotoDate(this.selectedDate);
			this.api.changeView('timeGridDay', {start: this.selectedDate});
			this.showForm = true;
		},
		onEventDrop({event, oldEvent, view}) {
			let props = oldEvent.extendedProps;
//			this.showForm = false;
			const startTime = moment(event.start).clone().format('HH:mm'),
				data = {
				id: event.id,
				crane_date: moment(event.start).clone().format('YYYY-MM-DD'),
				crane_time: startTime,
				cranable_type: this.addslashes(props.cranable_type),
				cranable_id: props.cranable_id,
			};
			this.update(data);

			if("timeGridDay" === view.type) {
				this.craneDate.crane_time = startTime;
			}
		},
		onChange(e) {
			let $el = $(e.target);
			if ('cranable_type' === $el.attr('name')) {
				this.$store.dispatch("craneDates/getBoats", $el.val());
			}
		},
		addslashes(str) {
			return (str + '').replace(/([\"'])/g, "\\$1");
		}
	},
}
</script>
