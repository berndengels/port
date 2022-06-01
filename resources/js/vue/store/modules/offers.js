const namespaced = true,
	state = () => {
		return {
			enabled: {},
		}
	},
	mutations = {
		mEnabled: (state, data) => state.enabled = data
	},
	getters = {
		enabled: (state) => {
			return state.enabled
		},
	},
	actions = {
		fetch({ commit }) {
			axios.get('/api/configOffers')
				.then(resp => {
					if(resp.data) {
						commit("mEnabled", resp.data);
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
