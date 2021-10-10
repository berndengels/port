require('./bootstrap');

import MyForm from './Libs/MyForm'
import Caravan from "./Libs/Caravan";
import Editor from './Libs/Editor'

window.MyForm   = new MyForm
window.Caravan  = new Caravan
window.Editor   = new Editor

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
