
class MyForm {
//	constructor() {};
	autocomplete = (listSelector, triggerSelector, options, binds) => {
		const $elSelect = $(listSelector);
		var data = [];

		$(triggerSelector).keyup(e => {
			var $el=$(e.target),$li=$('<li>'),i=0,item;
			$elSelect.empty();

			if($el.val().length > 0) {
				for(item of options) {
					if(item.name.indexOf($el.val()) !== -1) {
						data[item.id] = item
						$elSelect.append($($li.clone().attr('data-id', item.id).text(item.name)))
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
