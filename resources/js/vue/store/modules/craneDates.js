const namespaced = true,
	state = {
		date: {
			id: null,
			cranable_type: null,
			cranable_id: null,
			crane_date: null,
			crane_time: null
		},
		customerDates: null,
		dates: null,
		boats: null,
		cranableTypeOptions: null,
		errors: null,
		loading: true,
	},
	getters = {
		date: (state) => state.date,
		customerDates: (state) => state.customerDates,
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
		setCustomerDates(state, dates) {
			state.customerDates = dates
			state.loading = false
		},
		setBoats(state, boats) {
			state.boats = boats
		},
		setCranableTypeOptions(state, cranableTypeOptions) {
			state.cranableTypeOptions = cranableTypeOptions
		},
		setCranableType(state, cranableType) {
			state.date.cranable_type = cranableType
		},
		setCranableId(state, cranableId) {
			state.date.cranable_id = cranableId
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
						if(resp.data.cranableTypeOptions) {
							commit("setCranableTypeOptions", resp.data.cranableTypeOptions);
						}
						if(resp.data.cranableType && resp.data.customerDates) {
							commit("setCranableType", resp.data.cranableType);
							commit("setCustomerDates", resp.data.customerDates);
						}
						if(resp.data.boats) {
							commit("setBoats", resp.data.boats);
						}
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
		destroy({commit}, data) {
			axios.delete('/api/craneDates/' + data.id, data)
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
