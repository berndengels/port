
class Caravan {
//	constructor() {};
	autocomplete = (frm, caravanOptions) => {
		const $elSelect       = $('.autocomplete', frm),
			$elCarnumber    = $(frm.carnumber),
			$elCarlength    = $(frm.carlength),
			$elCountryId    = $(frm.country_id),
			$elEmail        = $(frm.email),
			caravans        = [];

		$elCarnumber.keyup(e => {
			var $el=$(e.target),$li=$('<li>'),i=0,item;
			$elSelect.empty();

			if($el.val().length > 0) {
				for(item of caravanOptions) {
					if(item.carnumber.indexOf($el.val().toUpperCase()) === 0) {
						caravans[item.id] = item
						$elSelect.append($($li.clone().attr('data-id', item.id).text(item.carnumber)))
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
			let $el = $(e.target)
			let caravan = caravans[$el.data('id')]
			$elCarnumber.val(caravan.carnumber)
			$elCarlength.val(caravan.carlength)
			$elCountryId.val(caravan.country_id)
			$elEmail.val(caravan.email)
			$elSelect.addClass('hidden');
		});
	};

	calculate = function(frm, calcUrl, caravanOptions) {
		const $elObserve = $('.calc', frm);

		$elObserve.change(() => {
			if(frm.from.value && frm.until.value && frm.persons.value && frm.carlength.value) {
				let formData = new FormData(),elem;
				console.info(frm.elements)
				for(elem of frm.elements) {
					formData.append(elem.name, elem.value)
				}
				formData.set('electric', frm.electric.checked ? 1 : 0)
				axios.post(calcUrl, formData)
					.then(resp => {
						frm.price.value = resp.data.total
						frm.prices.value = JSON.stringify(resp.data.prices)
					})
					.catch(err => console.error(err))
				;
			}
		});
	}
}
export default Caravan;
