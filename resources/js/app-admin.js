require('./bootstrap');

import MyForm from './Libs/MyForm'
import Prices from "./Libs/Prices";
import Editor from './Libs/Editor'
import Weather from "./Libs/Weather";

window.MyForm   = new MyForm
window.Prices   = new Prices
window.Editor   = new Editor
window.Weather  = new Weather;

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

if($('[name="csrf-token"]').is(":visible")) {
	$.ajaxSetup({
		headers: {'X-CSRF-Token': $('[name="csrf-token"]').attr('content')},
	});
}
$(document).ajaxError(function( event, xhr, settings, thrownError ) {
	console.error(xhr);
});
