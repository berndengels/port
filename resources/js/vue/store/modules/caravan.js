const namespaced = true,
	state = {
		todayVisits: null,
		errors: null,
		loading: true,
	},
	getters = {
		todayVisits: (state) => state.todayVisits,
		errors: (state) => state.errors,
		loading: (state) => state.loading,
	},
	mutations = {
		todayVisits(state, caravans) {
			state.todayVisits = caravans
			state.loading = false
		},
		errors(state, errors) {
			state.errors = errors
		},
	},
	actions = {
		store({commit}, caravan) {
			axios.post('/api/caravans', caravan)
				.then(resp => {
					if (resp.data.errors) {
						commit("errors", resp.data.errors);
					} else {
						commit("errors", null);
					}
				}).catch(err => console.error(err));
		},
		todayVisits({commit}) {
			axios.get('/api/caravans/todayVisits')
				.then(resp => {
					if (resp.data && resp.data.length > 0) {
						commit("todayVisits", resp.data);
					}
				}).catch(err => console.error(err));
		}
	};
export default {
	namespaced,
	state,
	getters,
	mutations,
	actions
}
