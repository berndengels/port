
const namespaced = true,
	state =  {
		dates: [],
		reservations: [],
		loading: true,
	},
	getters = {
		dates: (state) => state.dates,
		reservations: (state) => state.reservations,
		loading: (state) => state.loading,
	},
	mutations = {
		setDates(state, data) {
			state.dates = data
			state.loading = false
		},
		setReservations(state, data) {
			state.reservations = data
			state.loading = false
		},
	},
	actions = {
		fetch({ commit }) {
			axios.get('/api/rentals')
				.then(resp => {
					if(resp.data && resp.data.length > 0) {
						commit("setDates", resp.data);
					}
				}).catch(err => console.error(err));
		},
		fetchReservations({ commit }) {
			axios.get('/api/rentals/reservations')
				.then(resp => {
					if(resp.data && resp.data.length > 0) {
						commit("setReservations", resp.data);
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
