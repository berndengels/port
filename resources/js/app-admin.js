require('./bootstrap');
import CaravanPrice from './Libs/caravanPrice'
window.CaravanPrice = new CaravanPrice

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

