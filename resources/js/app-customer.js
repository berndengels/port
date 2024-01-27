require('./bootstrap');

import Weather from "L@/Weather";
import Message from "L@/Message";
import Navbar from "L@/Navbar";

import {createApp} from "vue"
import store from "./vue/store"
import mitt from 'mitt';

const emitter = mitt();
window.emitter = emitter;

import BookingCalendar from "v@/views/public/BookingCalendar.vue";
import BookingBerth from "v@/views/public/BookingBerth.vue";
import CraneDates from "v@/views/customer/CraneDates"

window.Weather = new Weather;
window.Message = new Message;
window.Navbar  = new Navbar;

$(document).ready(function () {
	const $sideNav = $('.sidenav');

	$(".menu-icon").click(() => {
		$sideNav.addClass('active')
	});
	$(".sidenav__close-icon").click(() => {
		$sideNav.removeClass('active')
	});
	let app;
	const bookingCalendar = document.getElementById('bookingCalendar'),
		bookingBerth = document.getElementById('bookingBerth'),
		craneDates =  document.getElementById('craneDates');

	switch (true) {
		case $(bookingCalendar).is(":visible"):
			app = createApp(BookingCalendar).use(store);
			app.mount(bookingCalendar);
			break;
		case $(bookingBerth).is(":visible"):
			app = createApp(BookingBerth).use(store);
			app.mount(bookingBerth);
			break
		case $(craneDates).is(":visible"):
			app = createApp(CraneDates).use(store);
			app.config.globalProperties.emitter = emitter;
			app.mount(craneDates, { ...craneDates.dataset });
			break
	}
});

