require('./bootstrap');
import $ from "jquery";
//require("./Mixins/MyCss");

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

