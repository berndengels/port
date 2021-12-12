
class MyForm {
	autofill(calcUrl, binds) {
		axios.get(calcUrl)
			.then(resp => {
				for(let key in binds) {
					$(binds[key]).val(resp.data[key]);
				}
			})
			.catch(err => console.error(err))
		;
	};
	autocomplete(listSelector, triggerSelector, options, optionTextField, binds) {
		const $elSelect = $(listSelector);
		var data = [];

		$(triggerSelector).keyup(e => {
			var $el=$(e.target),$li=$('<li>'),i=0;
			$elSelect.empty();

			if($el.val().length > 0) {
				for (let [key, val] of Object.entries(options)) {
					if(val[optionTextField].toLowerCase().indexOf($el.val().toLowerCase()) !== -1) {
						data[key] = val
						$elSelect.append($($li.clone().attr('data-id', key).text(val[optionTextField])))
						i++
					}
				}
				if(i > 0) {
					$elSelect.removeClass('hidden');
				} else {
					$elSelect.addClass('hidden');
				}
			}
		});

		$elSelect.click(e => {
			let $el = $(e.target),key,
				item = data[$el.data('id')];
			for(key in binds) {
				$(binds[key]).val(item[key]);
			}
			$elSelect.addClass('hidden');
		});
	};
}
export default MyForm;
