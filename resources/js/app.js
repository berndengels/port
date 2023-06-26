require('./bootstrap');
import Weather from "./Libs/Weather";
import Message from "./Libs/Message";
import {createApp} from "vue"
import store from "./vue/store"
import BookingCalendar from "v@/views/public/BookingCalendar.vue";
import BookingBerth from "v@/views/public/BookingBerth.vue";

window.Weather = new Weather;
window.Message = new Message;

$(document).ready(function () {
	const $sideNav = $('.sidenav');

	$(".menu-icon").click(() => {
		$sideNav.addClass('active')
	});
	$(".sidenav__close-icon").click(() => {
		$sideNav.removeClass('active')
	});
	let app;
	switch (true) {
		case $("#bookingCalendar").is(":visible"):
			app = createApp(BookingCalendar).use(store);
			app.mount("#bookingCalendar");
			break;
		case $("#bookingBerth").is(":visible"):
			app = createApp(BookingBerth).use(store);
			app.mount("#bookingBerths");
			break
	}
});

