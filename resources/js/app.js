require('./bootstrap');
import $ from "jquery";
require("./Mixins/MyCss");

$(document).ready(function () {
	$(".delSoft").click(function () {
		return confirm("Daten wirklich löschen");
	});
});

