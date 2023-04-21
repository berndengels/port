const availableStats = ['caravans','boats','guestBoats','rentals','rentalSalesVolumes'],
	namespaced = true,
	minLimit = 5,
	translations = {
		House: "Häuser",
		Houseboat: "Hausboote",
		Apartment: "Wohnungen",
	},
	__ = (key) => translations[key],
	state = {
		minLimit: 5,
		caravans: null,
		boats: null,
		guestBoats: null,
		rentals: null,
		rentalSalesVolumes: null,
		loading: true,
		error: {
			caravans: null,
			boats: null,
			guestBoats: null,
			rentals: null,
			rentalSalesVolumes: null,
		},
	},
	mutations = {
		caravans(state, data) {
			state.caravans = data
			state.loading = false
		},
		boats(state, data) {
			state.boats = data
			state.loading = false
		},
		rentals(state, data) {
			state.rentals = data
			state.loading = false
		},
		rentalSalesVolumes(state, data) {
			state.rentalSalesVolumes = data
			state.loading = false
		},
		guestBoats(state, data) {
			state.guestBoats = data
			state.loading = false
		},
		error(state, {model, msg}) {
			state.error[model] = msg ?? "Fehler"
			state.loading = false
		},
	},
	getters = {
		caravans: (state) => state.caravans,
		guestBoats: (state) => state.guestBoats,
		boats: (state) => state.boats,
		rentals: (state) => state.rentals,
		error: (state) => state.error,
		rentalSalesVolumes: (state) => {
			if(!state.rentalSalesVolumes) {
				return null;
			}
			var dates=[],series=[],rentals={...state.rentalSalesVolumes},
			colors = {
				Apartment: "red",
				House: "blue",
				Houseboat: "green",
			},
			models = Object.keys(rentals);
			dates = Object.keys(rentals[models[0]])
			let trans;
			for(let model in rentals) {
				trans = __(model)
				series[trans] = {
					type: 'bar',
					name: trans,
					itemStyle: { color: colors[model] },
					data: Object.values(rentals[model]),
				};
			}
			return {
				legends: models.map(m => __(m)),
				dates: dates,
				series: [
					series.Wohnungen ?? null,
					series.Hausboote ?? null,
					series.Häuser ?? null,
				]
			}
		},
		loading: (state) => state.loading,
	},
	actions = {
		async get({ commit }, item) {
			if(-1 === availableStats.indexOf(item)) {
				return false
			}
			let resp;
			try {
				resp = await axios.get('api/stats/' + item);
				switch(resp.status) {
					case 200:
						if(resp.data && resp.data.length > minLimit) {
							commit(item, resp.data)
						} else {
							commit("error", {model: item, msg: "zuwenig Daten vorhanden"})
						}
						break;
					case 204:
						commit("error", {model: item, msg: "Keine Daten vorhanden"})
						break;
					default:
						commit("error", {model: item, msg: "Unbekannter Fehler"})
						break;
				}
			} catch(err) {
				err => console.error(err)
			}
		},
		async getSalesVolumes({ commit }) {
			let resp;
			try {
				resp = await axios.get('api/stats/rentalSalesVolumes');
				if(200 === resp.status && resp.data) {
					commit("rentalSalesVolumes", resp.data)
				} else if (204 === resp.status) {
					commit("error", {model: "rentalSalesVolumes", msg: "Keine Daten vorhanden"})
				}
			} catch(err) {
				err => console.error(err)
			}
		},
	};
export default {
	namespaced,
	state,
	mutations,
	getters,
	actions
}
