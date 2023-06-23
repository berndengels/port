<template>
	<div class="card align-self-center calendar">
		<div class="card-header">
			<strong v-html="title"></strong>
		</div>
		<div v-if="loading" class="card-body p-3 loader-wrapper">
			<pulse-loader color="#394263" size="20px"/>
		</div>
		<div v-else class="card-body p-3">
			<FullCalendar :options="options"/>
		</div>
	</div>
</template>

<script>
import FullCalendar from 'v@/components/fullcalendar'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

export default {
	name: "RentalsCardCalendar",
	components: {FullCalendar, PulseLoader},
	props: {
		title: String,
		onlyFromToday: Boolean,
	},
	data() {
		return {
			/*
						filter: {
							Apartment: true,
							House: true,
							Houseboat: true,
						},
			*/
			loading: true,
			options: {
				plugins: [dayGridPlugin, interactionPlugin],
				dateClick: (e) => {
					const option = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}
				},
				initialView: 'dayGridMonth',
				contentWidth: '600px',
				contentHeight: '400px',
				selectable: true,
				selectOverlap: true,
				locale: 'de',
				firstDay: 1,
				displayEventTime: false,
				events: [],
			},
		}
	},
	computed: {
		dates() {
			return this.onlyFromToday
				? this.$store.state.rentals.reservations
				: this.$store.state.rentals.dates
		},
		offers() {
			return this.$store.state.offers.enabled
		},
		countOffers() {
			return this.$store.state.offers.countEnabled
		}
	},
	methods: {
		/*
				changeFilter() {
					let data = [],entries = [], r;
					for (r in this.filter) {
						data[r] = {name: r, val: this.filter[r]};
					}
					this.options.events = this.dates.filter(el => el.relation === data[el.relation]['name'] && true === data[el.relation]['val']);
				}
		*/
	},
	created() {
		if (this.onlyFromToday) {
			this.options.validRange = (nowDate) => {
				return {
					start: nowDate,
				};
			}
		}
		this.options.events = this.dates;
		this.loading = false;
	},
}
</script>
