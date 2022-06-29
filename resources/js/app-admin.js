require('./bootstrap');

import MyForm from "./Libs/MyForm"
import Prices from "./Libs/Prices"
import Editor from "./Libs/Editor"
import Weather from "./Libs/Weather"
import Car from "./Libs/Car"
import Tooltip from "./Libs/Tooltip";
import Edit from "./Libs/Edit";
import Geo from "./Libs/Geo";
import MyCalendar from "./Libs/MyCalendar";
import { createApp } from "vue"
import store from "./vue/store"
import mitt from 'mitt';
const emitter = mitt();
window.emitter = emitter;

import AdminDashboard from "./vue/views/admin/Dashboard"
import AdminGuestboatBerths from "./vue/views/admin/GuestboatBerths"

window.MyForm   = new MyForm;
window.Prices   = new Prices;
window.Editor   = new Editor;
window.Edit     = new Edit;
window.Weather  = new Weather;
window.Car      = new Car;
window.Tooltip  = new Tooltip;
window.Geo      = new Geo;
window.MyCalendar = new MyCalendar;

$(document).ready(function () {
	const $sideNav = $('.sidenav');

	$(".delSoft").click(function () {
		return confirm("Daten wirklich löschen");
	});
	$(".menu-icon").click(() => {
		$sideNav.addClass('active')
	});
	$(".sidenav__close-icon").click(() => {
		$sideNav.removeClass('active')
	});

	let app;
	switch(true) {
		case $("#adminDashboard").is(":visible"):
			app = createApp(AdminDashboard).use(store);
			app.config.globalProperties.emitter = emitter;
			app.mount("#adminDashboard");
			break;
		case $("#adminGuestboatBerths").is(":visible"):
			app = createApp(AdminGuestboatBerths).use(store);
			app.config.globalProperties.emitter = emitter;
			app.mount("#adminGuestboatBerths");
			break
	}
});
if($('[name="csrf-token"]').is(":visible")) {
	$.ajaxSetup({
		headers: {'X-CSRF-Token': $('[name="csrf-token"]').attr('content')},
	});
}
$(document).ajaxError(function( event, xhr, settings, thrownError ) {
	console.error(xhr);
});
