require('./bootstrap');
toastr.options = {
	"closeButton": true,
	"debug": false,
	"newestOnTop": false,
	"progressBar": false,
	"positionClass": "toast-top-right",
	"preventDuplicates": true,
	"showDuration": "300",
	"hideDuration": "1000",
	"timeOut": "3000",
	"extendedTimeOut": "1000",
	"showEasing": "swing",
	"hideEasing": "linear",
	"showMethod": "fadeIn",
	"hideMethod": "fadeOut"
};
import MyForm from "./Libs/MyForm"
import Prices from "./Libs/Prices"
import Editor from "./Libs/Editor"
import Weather from "./Libs/Weather"
import Car from "./Libs/Car"
import Tooltip from "./Libs/Tooltip";
import Edit from "./Libs/Edit";
import Geo from "./Libs/Geo";
import MyDropzone from "./Libs/MyDropzone";
import Draggable from "./Libs/Draggable";
import MyCalendar from "./Libs/MyCalendar";
import Fullscreen from "./Libs/Fullscreen";
import {createApp} from "vue"
import store from "./vue/store"
import mitt from 'mitt';

const emitter = mitt();
window.emitter = emitter;

import AdminDashboard from "v@/views/admin/Dashboard"
import AdminBerths from "v@/views/admin/Berths"
import AdminCraneDates from "v@/views/admin/CraneDates"

window.MyForm = new MyForm;
window.Prices = new Prices;
window.Editor = new Editor;
window.Edit = new Edit;
window.Weather = new Weather;
window.Car = new Car;
window.Tooltip = new Tooltip;
window.Geo = Geo;
window.MyCalendar = new MyCalendar;
window.MyDropzone = new MyDropzone;
window.Fullscreen = new Fullscreen;

$(document).ready(function () {
	window.Draggable = new Draggable();
	const $sideNav = $('.sidenav');

	$(".delSoft").click(function () {
		return confirm("Daten wirklich löschen");
	});
	$(".help").click(function (e) {
		e.preventDefault();
		const $t = $(e.target), help = $t.data('help');
		toastr.options = {
			escapeHtml: false,
			closeButton: true,
			preventDuplicates: true,
			timeOut: 0,
			extendedTimeOut: 0,
			positionClass: "toast-top-center",
//			positionClass: "toast-top-full-width",
			hideEasing: "linear",
			hideMethod: "fadeOut",
		};
		toastr.info(help);
	});
	if ($("form .calc").is(":visible")) {
		toastr.options = {
			escapeHtml: false,
			closeButton: true,
			preventDuplicates: true,
//			timeOut: 0,
//			extendedTimeOut: 0,
			positionClass: "toast-top-right",
			hideEasing: "linear",
			hideMethod: "fadeOut",
		};
		toastr.success("Zur Preisberechnung bitte alle grünen Felder ausfüllen. Checkbox ist natürlich optional.");
	}
	$(".menu-icon").click(() => {
		$sideNav.addClass('active')
	});
	$(".sidenav__close-icon").click(() => {
		$sideNav.removeClass('active')
	});

	let app;
	switch (true) {
		case $("#adminDashboard").is(":visible"):
			app = createApp(AdminDashboard).use(store);
			app.config.globalProperties.emitter = emitter;
			app.mount("#adminDashboard");
			break;
		case $("#adminBerths").is(":visible"):
			app = createApp(AdminBerths).use(store);
			app.config.globalProperties.emitter = emitter;
			app.mount("#adminBerths");
			break
		case $("#adminCraneDates").is(":visible"):
			app = createApp(AdminCraneDates).use(store);
			app.config.globalProperties.emitter = emitter;
			app.mount("#adminCraneDates");
			break
	}
	$('.btn-print').click((e) => {
		e.preventDefault();
		const $target = $(e.target),
			link = $target.parent().attr('href'),
			params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=800,height=800,left=100,top=100`,
			printView = window.open(link, 'printView', params);

		$(printView).ready(() => {
			setTimeout(() => {
				printView.print()
			}, 1000);
		})
	});
});
if ($('[name="csrf-token"]').is(":visible")) {
	$.ajaxSetup({
		headers: {'X-CSRF-Token': $('[name="csrf-token"]').attr('content')},
	});
}
$(document).ajaxError(function (event, xhr, settings, thrownError) {
	console.error(xhr);
});
