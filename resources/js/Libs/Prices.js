
class Prices {
	caravanDates = {
		calculate(frm, calcUrl) {
			const $elObserve = $('.calc', frm);
			$elObserve.change((e) => {
				this.calc(frm, calcUrl)
			});
		},
		calc(frm, calcUrl) {
			if(frm.from.value && frm.until.value && frm.persons.value && frm.carlength.value) {
				let formData = new FormData(),elem;
				for(elem of frm.elements) {
					formData.append(elem.name, elem.value)
				}

				formData.set('electric', frm.electric.checked ? 1 : 0)

				axios.post(calcUrl, formData)
					.then(resp => {
						frm.price.value = Math.ceil(resp.data.total)
						frm.prices.value = JSON.stringify(resp.data)
					})
					.catch(err => console.error(err))
				;
			}
		}
	}
	boatDates = {
		calculate(frm, calcUrl) {
			const $elObserve = $('.calc', frm);

			$elObserve.change(() => {
				this.calc(frm, calcUrl)
			})
		},
		calc(frm, calcUrl) {
			if(frm.from.value && frm.until.value && "" !== frm.boat_id.value && "" !== frm.modus.value) {
				let formData = new FormData(),elem;
				for(elem of frm.elements) {
					formData.append(elem.name, elem.value)
				}

				formData.set('crane', frm.crane.checked ? 1 : 0)
				formData.set('mast_crane', frm.mast_crane.checked ? 1 : 0)
				formData.set('cleaning', frm.cleaning.checked ? 1 : 0)

				axios.post(calcUrl, formData)
					.then(resp => {
						frm.price.value = Math.ceil(resp.data.total)
						frm.prices.value = JSON.stringify(resp.data)
					})
					.catch(err => console.error(err))
				;
			}
		}
	}
	guestBoatDates = {
		calculate(frm, calcUrl) {
			const $elObserve = $('.calc', frm);
			$elObserve.change(() => {
				this.calc(frm, calcUrl)
			})
		},
		calc(frm, calcUrl) {
			if(frm.from.value && frm.until.value && "" !== frm.length.value) {
				let formData = new FormData(),elem;
				for(elem of frm.elements) {
					formData.append(elem.name, elem.value)
				}

				formData.set('electric', frm.electric.checked ? 1 : 0)

				axios.post(calcUrl, formData)
					.then(resp => {
						console.info(resp.data)
						frm.price.value = Math.ceil(resp.data.total)
						frm.prices.value = JSON.stringify(resp.data)
					})
					.catch(err => console.error(err))
				;
			}
		}
	}
}
export default Prices;
