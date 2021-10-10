
class Caravan {
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
