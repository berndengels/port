
require('./bootstrap');

import Weather from "./Libs/Weather";
window.Weather = new Weather;

$(document).ready(function () {
	const $sideNav = $('.sidenav');

	$(".menu-icon").click(() => {
		$sideNav.addClass('active')
	});
	$(".sidenav__close-icon").click(() => {
		$sideNav.removeClass('active')
	});
});
