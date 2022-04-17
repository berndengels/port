require('./bootstrap');

const axios = require('axios');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.baseURL = process.env.MIX_API_URL;
axios.defaults.withCredentials = true;
window.axios = axios;
//window.moment = require('moment');
var moment = require('moment'); // require
window.moment = moment;

import MyForm from "./Libs/MyForm"
import Prices from "./Libs/Prices"
import Editor from "./Libs/Editor"
import Weather from "./Libs/Weather"
import Car from "./Libs/Car"
import Tooltip from "./Libs/Tooltip";
import { createApp } from "vue"
import store from "./vue/store"
import Main from "./Main"
import AdminDashboard from "./vue/views/admin/Dashboard"

window.MyForm   = new MyForm;
window.Prices   = new Prices;
window.Editor   = new Editor;
window.Weather  = new Weather;
window.Car      = new Car;
window.Tooltip  = new Tooltip;

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

	switch(true) {
		case $("#adminDashboard").is(":visible"):
			createApp(AdminDashboard).use(store).mount("#adminDashboard");
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
