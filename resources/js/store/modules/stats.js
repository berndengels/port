const availableStats = ['caravans','boats','guestBoats'],
	minLimit = 10,
	namespaced = true,
	state = () => {
		return {
			caravans: null,
			boats: null,
			guestBoats: null,
		}
	},
	mutations = {
		caravans(state, data) {
			state.caravans = data
		},
		boats(state, data) {
			state.boats = data
		},
		guestBoats(state, data) {
			state.guestBoats = data
		},
	},
	getters = {
		caravans: (state) => state.caravans,
		guestBoats: (state) => state.guestBoats,
		boats: (state) => state.boats,
	},
	actions = {
		get({ commit }, item) {
			if(-1 === availableStats.indexOf(item)) {
				return false
			}
			axios.get('api/stats/' + item)
				.then(resp => {
					if(resp.data && resp.data.length > minLimit) {
						commit(item, resp.data)
					}
				}).catch(err => console.error(err));
		},
	};
export default {
	namespaced,
	state,
	mutations,
	getters,
	actions
}
