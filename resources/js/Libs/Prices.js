class Prices {
	calculate(frm, calcUrl) {
		const $elObserve = $('.calc', frm);
		$elObserve.change((e) => {
			this.calc(frm, calcUrl)
		});
	}
	calc(frm, calcUrl) {
		let formData = new FormData(),elem;
		for(elem of frm.elements) {
			if("" !== elem.name && "" !== elem.value && elem.value || "checkbox" === elem.type) {
				if("checkbox" === elem.type) {
					formData.set(elem.name, elem.checked ? 1 : 0)
				} else {
					formData.set(elem.name, elem.value)
				}
			}
		}
/*
		for (let el of formData.entries()) {
			console.info("formData", el);
		}
*/
		axios.post(calcUrl, formData)
			.then(resp => {
				frm.price.value = Math.ceil(resp.data.total);
				frm.prices.value = JSON.stringify(resp.data)
			})
			.catch(err => console.error(err))
		;
	}
}
export default Prices;
