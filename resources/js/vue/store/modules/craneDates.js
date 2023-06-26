const namespaced = true,
	state = {
		dates: null,
		boats: null,
		cranableTypeOptions: null,
		errors: null,
		loading: true,
	},
	getters = {
		dates: (state) => state.dates,
		boats: (state) => state.boats,
		cranableTypeOptions: (state) => state.cranableTypeOptions,
		errors: (state) => state.errors,
		loading: (state) => state.loading,
	},
	mutations = {
		setDates(state, dates) {
			state.dates = dates
			state.loading = false
		},
		setBoats(state, boats) {
			state.boats = boats
		},
		setCranableTypeOptions(state, cranableTypeOptions) {
			state.cranableTypeOptions = cranableTypeOptions
		},
		storeDate(state, date) {
			state.dates.push(date)
			state.loading = false
		},
		updateDate(state, date) {
			state.dates = state.dates.map(d => d.id === date.id ? date : d)
			state.loading = false
		},
		destroyDate(state, date) {
			state.dates = state.dates.filter(d => d.id !== date.id)
			state.loading = false
		},
		errors(state, errors) {
			state.errors = errors
		},
	},
	actions = {
		all({commit}) {
			axios.get('/api/craneDates')
				.then(resp => {
					if (resp.data) {
						commit("setDates", resp.data.dates);
						commit("setCranableTypeOptions", resp.data.cranableTypeOptions);
					}
				}).catch(err => console.error(err));
		},
		getBoats({commit}, data) {
			axios.post('/api/craneDates/cranable', {cranable_type: data})
				.then(resp => {
					if (resp.data) {
						commit("setBoats", resp.data);
					}
				}).catch(err => console.error(err));
		},
		store({commit}, data) {
			axios.post('/api/craneDates', data)
				.then(resp => {
					if (resp.data.errors) {
						commit("errors", resp.data.errors);
					} else {
						commit("errors", null);
						commit("storeDate", resp.data.craneDate);
					}
				}).catch(err => console.error(err));
		},
		update({commit}, data) {
			axios.put('/api/craneDates/' + data.id, data)
				.then(resp => {
					if (resp.data.errors) {
						commit("errors", resp.data.errors);
					} else {
						commit("errors", null);
						commit("updateDate", resp.data.craneDate);
					}
				}).catch(err => console.error(err));
		},
		destroy({commit}, date) {
			axios.delete('/api/craneDates' + data.id, date)
				.then(resp => {
					if (resp.data.errors) {
						commit("errors", resp.data.errors);
					} else {
						commit("errors", null);
						commit("destroyDate", resp.data.craneDate);
					}
				}).catch(err => console.error(err));
		},
	};
export default {
	namespaced,
	state,
	getters,
	mutations,
	actions
}
