class MyForm {
	autofill(calcUrl, binds, toHide = []) {
		axios.get(calcUrl)
			.then(resp => {
				let key;
				for (key in binds) {
					$(binds[key]).val(resp.data[key]);
				}
				if (toHide.length > 0) {
					if (undefined !== resp.data.type) {
						if ("motor" === resp.data.type) {
							for (key in toHide) {
								$(toHide[key]).hide();
							}
						} else {
							for (key in toHide) {
								$(toHide[key]).show();
							}
						}
					}
				}
			})
			.catch(err => console.error(err))
		;
	};

	autocomplete(listSelector, triggerSelector, options, optionTextField, binds) {
		const $elSelect = $(listSelector);
		var data = [];
		$(triggerSelector).keyup(e => {
			let $el = $(e.target), $li = $('<li>'), i = 0;
			$elSelect.empty();

			if ($el.val().length > 0) {
				for (let [key, val] of Object.entries(options)) {
					if (undefined !== val[optionTextField] && val[optionTextField].toLowerCase().indexOf($el.val().toLowerCase()) !== -1) {
						data[key] = val;
						$elSelect.append($($li.clone().attr('data-id', key).text(val[optionTextField])));
						i++
					}
				}
				if (i > 0) {
					$elSelect.removeClass('d-none');
				} else {
					$elSelect.addClass('d-none');
				}
			}
		});
		$elSelect.click(e => {
			let $el = $(e.target), key,
				item = data[$el.data('id')];
			for (key in binds) {
				$(binds[key]).val(item[key]);
			}
			$elSelect.addClass('d-none');
		});
	};
}

export default MyForm;
