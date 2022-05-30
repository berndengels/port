const namespaced = true,
	state = () => {
		return {
			dates: null,
		}
	},
	mutations = {
		dates(state, data) {
			state.dates = data
		},
	},
	getters = {
		dates: (state) => state.dates,
	},
	actions = {
		fetchDates({ commit }) {
			axios.get('/api/houseboats')
				.then(resp => {
					if(resp.data && resp.data.length > 0) {
						commit("dates", resp.data);
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
