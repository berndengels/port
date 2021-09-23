require('./bootstrap');
import $ from "jquery";

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
});

