
class Edit {
	toggle(route, attribute, switchSelector = 'i.switch') {
		const token = $('[name="csrf-token"]').attr('content'),
			clOn = "text-green-600 fa-check-circle on",
			clOff = "text-red-600 fa-times off";

		$(switchSelector).click(e => {
			var $t = $(e.target),
				toggle = $t.hasClass('on') ? 0 : 1,
				id = $t.parent('td').attr('rel'),
				url = route.replace(/\/$/,"") + "/" + id,
				data = {
					"attribute": attribute,
					"value": toggle,
					"_token": token
				}
			;
			$.post(url, data).done(resp => {
				console.info(resp);
				if(resp[attribute]) {
					$t.removeClass(clOff).addClass(clOn);
					$("#"+resp.name).show();
				} else {
					$t.removeClass(clOn).addClass(clOff);
					$("#"+resp.name).hide();
				}
			});
		});
	}
}
export default Edit
