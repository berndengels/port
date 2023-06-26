<template>
	<div class="container mt-3 ms-0 ps-0 dashboard d-flex">
		<div class="row gy-3 ps-0 ms-0">
			<div v-if="countEnabled > 0" class="col-10 col-sm-10 col-lg-5">
				<Weather/>
			</div>
			<div v-else class="col-10 col-sm-10 col-lg-6">
				<Weather/>
			</div>
			<div class="col-10 col-sm-10 col-lg-5" v-if="caravansToday && enabled.Caravan">
				<CaravansToday :caravans="caravansToday"/>
			</div>
			<div class="col-10 col-sm-10 col-lg-5" v-show="null !== caravans" v-if="caravans && enabled.Caravan">
				<VisitsStats title="Caravan Besucher" model="caravans" :data="caravans" color="#ff025d"/>
			</div>
			<div class="col-10 col-sm-10 col-lg-5" v-show="null !== boats" v-if="boats && enabled.Boat">
				<VisitsStats title="Boots Termine" model="boats" :data="boats" color="#377cff"/>
			</div>
			<div class="col-10 col-sm-10 col-lg-5" v-show="null !== guestBoats" v-if="guestBoats && enabled.Boat">
				<VisitsStats title="Gastboot Besuche" model="guestBoats" :data="guestBoats" color="#03926e"/>
			</div>
			<!--div class="col-10 col-sm-10 col-lg-5" v-show="null !== rentals" v-if="rentals && countEnabled > 0">
				<VisitsStats title="Vermietung" model="rentals" :data="rentals" color="#3f70ff" />
			</div-->
			<div class="col-10 col-sm-10 col-lg-5" model="rentals" v-show="null !== rentals"
				 v-if="rentals && countEnabled > 0">
				<SalesVolumeStats
					title="monatliche Umsätze Vermietung in €"
					apartmentEnabled="apartmentEnabled"
					HouseEnabled="HouseEnabled"
					houseboatEnabled="houseboatEnabled"
				/>
			</div>
			<div class="col-10 col-sm-10 col-lg-5" v-show="null !== rentals" v-if="rentals && countEnabled > 0">
				<RentalsCardCalendar title="Vermietungs Kalender"/>
			</div>
		</div>
	</div>
</template>

<script>
import Weather from "../../components/Weather";
import VisitsStats from "../../components/VisitsStats";
import CaravansToday from "../../components/CaravansToday";
import RentalsCardCalendar from "v@/components/RentalsCardCalendar.vue";
import SalesVolumeStats from "v@/components/SalesVolumeStats.vue";

export default {
	name: "Dashboard",
	components: {Weather, RentalsCardCalendar, CaravansToday, VisitsStats, SalesVolumeStats},
	data() {
		return {
			houseEnabled: false,
			apartmentEnabled: false,
			houseboatEnabled: false,
			boatsEnabled: false,
			caravansEnabled: false,
			countEnabled: 0,
			caravansToday: null,
			caravans: null,
			boats: null,
			rentals: null,
			guestBoats: null,
			enabled: null,
		}
	},
	beforeCreate() {
		this.$store.dispatch("stats/get", "caravans")
		this.$store.dispatch("stats/get", "boats")
		this.$store.dispatch("stats/get", "guestBoats")
		this.$store.dispatch("stats/get", "rentals")
		this.$store.dispatch("stats/getSalesVolumes")
		this.$store.dispatch("offers/fetch")
		this.$store.dispatch("weather/fetch")
		this.$store.dispatch("rentals/fetch")
	},
	mounted() {
		this.getData()
	},
	methods: {
		getData() {
			setTimeout(() => {
				this.enabled = this.$store.state.offers.enabled;
				this.countEnabled = this.$store.state.offers.countEnabled;
				this.caravans = this.$store.state.stats.caravans;
				this.caravansToday = this.$store.state.caravan.caravansToday;
				this.boats = this.$store.state.stats.boats;
				this.guestBoats = this.$store.state.stats.guestBoats;
				this.rentals = this.$store.state.stats.rentals;
			}, 1000);
		}
	}
}
</script>
