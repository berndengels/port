
class Prices {
	caravanDates = {
		calculate: (frm, calcUrl) => {
			const $elObserve = $('.calc', frm);

			$elObserve.change((e) => {
				if(frm.from.value && frm.until.value && frm.persons.value && frm.carlength.value) {
					let formData = new FormData(),elem;
//					console.info(e.target.name + ": " + e.target.value)
					for(elem of frm.elements) {
						formData.append(elem.name, elem.value)
					}

				formData.set('electric', frm.electric.checked ? 1 : 0)

					axios.post(calcUrl, formData)
						.then(resp => {
							frm.price.value = resp.data.total
							frm.prices.value = JSON.stringify(resp.data)
						})
						.catch(err => console.error(err))
					;
				}
			})
		}
	}
	boatDates = {
		calculate: (frm, calcUrl) => {
			const $elObserve = $('.calc', frm);

			$elObserve.change((e) => {
				if("" !== frm.boat_id.value && "" !== frm.modus.value) {
					let formData = new FormData(),elem;
//					console.info(e.target.name + ": " + e.target.value)
					for(elem of frm.elements) {
						formData.append(elem.name, elem.value)
					}

					formData.set('crane', frm.crane.checked ? 1 : 0)
					formData.set('mast_crane', frm.mast_crane.checked ? 1 : 0)
					formData.set('cleaning', frm.cleaning.checked ? 1 : 0)
//					formData.forEach((v,k) => console.info(k+": "+v))
					axios.post(calcUrl, formData)
						.then(resp => {
//							console.info(resp.data)
							frm.price.value = resp.data.total
							frm.prices.value = JSON.stringify(resp.data)
						})
						.catch(err => console.error(err))
					;
				}
			})
		}
	}
}
export default Prices;
