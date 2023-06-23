const namespaced = true,
	state = {
		enabled: {},
		countEnabled: 0,
		loading: true,
	},
	mutations = {
		mEnabled: (state, data) => {
			const rentals = ['Apartment', 'House', 'Houseboat'];
			let k;
			for (k in data) {
				state.enabled[k] = !!data[k];
				if (undefined !== rentals.find(el => el === k)) {
					state.countEnabled++;
				}
			}
			state.loading = false
		}
	},
	getters = {
		enabled: (state) => state.enabled,
		countEnabled: (state) => state.countEnabled,
		loading: (state) => state.loading,
	},
	actions = {
		fetch({commit}) {
			axios.get('/api/configOffers')
				.then(resp => {
					if (resp.data) {
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
