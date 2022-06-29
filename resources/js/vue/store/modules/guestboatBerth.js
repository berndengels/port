const namespaced = true,
	state = () => {
		return {
			data: null,
			selected: null,
			errors: null,
			calcData: {
				prefix: "A",
				enabled: true,
				start: 3,
				end: 12,
				width: null,
				length: 12,
				daily_price: 12,
			},
		}
	},
	mutations = {
		setSelected: (state, data) => {
			state.selected = data;
			state.data = state.data.map(b => b.properties.id === data.properties.id ? data : b);
			emitter.emit('geoDataSelected', data)
		},
		mSetData: (state, data) => { state.data = data },
		setCalcData: (state, data) => { state.calcData = data },
		mPushSelected: (state, data) => { state.data.push(data) },
		destroySelected: (state, data) => { state.data = state.data.filter(b => b !== data) },
		updateSelected: (state, data) => {
			state.selected = data;
			state.data = state.data.map(b => b.properties.id === data.properties.id ? data : b)
		},
		errors: (state, errors) => { state.errors = errors },
	},
	getters = {
		data: (state) => state.data,
		calcData: (state) => state.calcData,
		selected: (state) => state.selected,
		errors: (state) => state.errors,
	},
	actions = {
		fetchData({ commit }) {
			axios.get('/api/guestboatBerths')
				.then(resp => {
					if(resp.data.errors) {
						commit("errors", resp.data.errors);
					} else if (resp.data && resp.data.length > 0) {
						commit("errors", null);
						commit("mSetData", resp.data);
					} else {
						commit("errors", null);
					}
				}).catch(err => console.info("error", err));

		},
		refill({ commit }, data) {
			axios.post('/api/guestboatBerths/refill', {features: data})
				.then(resp => {
					if(resp.data.errors) {
						commit("errors", resp.data.errors);
					} else if (resp.data && resp.data.length > 0) {
						commit("errors", null);
						commit("mSetData", resp.data);
					} else {
						commit("errors", null);
					}
				}).catch(err => console.error(err));
		},
		store({ commit }, data) {
			axios.post('/api/guestboatBerths', { ...data.properties })
				.then(resp => {
					if(resp.data.errors) {
						commit("errors", resp.data.errors);
					} else {
						commit("errors", null);
						commit("mPushSelected", resp.data);
					}
				}).catch(err => console.error(err));
		},
		update({ commit }, data) {
			axios.put('/api/guestboatBerths/' + data.properties.id, { ...data.properties })
				.then(resp => {
					if(resp.data.errors) {
						commit("errors", resp.data.errors);
					} else {
						commit("errors", null);
						commit("updateSelected", resp.data);
					}
				}).catch(err => console.error(err));
		},
		detroy({ commit }, data) {
			axios.delete('/api/guestboatBerths/' + data.properties.id)
				.then(resp => {
					if(resp.data.errors) {
						commit("errors", resp.data.errors);
					} else {
						commit("errors", null);
						commit("destroySelected", resp.data);
					}
				}).catch(err => console.error(err));
		},
		select({ commit }, data) {
			commit("setSelected", data);
		},
		setCalcData({ commit }, data) {
			commit("setCalcData", data);
		},
		setData({ commit }, data) {
			commit("mSetData", data);
		},
		addData({ commit }, data) {
			commit("mPushSelected", data);
		},
	};
export default {
	namespaced,
	state,
	getters,
	mutations,
	actions
}
