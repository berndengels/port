const namespaced = true,
	state = () => {
		return {
			data: null,
			docks: null,
//			selected: null,
			selected: {
				boat_dock_id: 1,
				number: null,
				enabled: false,
				width: null,
				length: null,
				daily_price: null,
			},
			selectedDock: null,
			errors: null,
			calcData: {
				boat_dock_id: 1,
				dock: null,
				enabled: true,
				start: 20,
				end: 35,
				width: null,
				length: 12,
				daily_price: 12,
			},
		}
	},
	mutations = {
		setSelected: (state, data) => {
			state.selected = data;
			console.info("selected", data)
			emitter.emit('geoDataSelected', data)
		},
		setSelectedDock: (state, data) => {
			state.selectedDock = data;
			emitter.emit('geoDockSelected', data)
		},
		mSetData: (state, data) => { state.data = data },
		mSetDocks: (state, data) => { state.docks = data },
		setCalcData: (state, data) => { state.calcData = data },
		mPushSelected: (state, data) => {
			if(state.data && state.data.length > 0) {
				data.forEach(el => state.data.push(el));
			} else {
				state.data = data
			}
			emitter.emit('data:updated', {data: state.data})
		},
		destroySelected: (state, data) => {
			if(state.data && state.data.length > 0) {
				state.data = state.data.filter(b => b !== data)
			}
		},
		updateSelected: (state, data) => {
			console.info("updateSelected", data)
			return;
			state.data = state.data.map(b => b.id === data.id ? data : b)
		},
		updateFormSelected: (state, data) => {
			console.info("updateFormSelected", data)
			return;
			state.data = state.data.map(b => b.id === data.id ? data : b)
		},
		errors: (state, errors) => { state.errors = errors },
	},
	getters = {
		data: (state) => state.data,
		docks: (state) => state.docks,
		docksOptions: (state) => {
			if(state.docks && state.docks.length > 0) {
				let data = state.docks.map(i => {
					return {"id": i.id, "name": i.name}
				});
				data.unshift({id: "", name: "bitte wählen"});
				return data;
			}
			return null;
		},
		calcData: (state) => state.calcData,
		selected: (state) => state.selected ?? null,
		selectedDock: (state) => state.selectedDock,
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
		fetchDocks({ commit }) {
			axios.get('/api/guestboatBerths/docks')
				.then(resp => {
					if(resp.data.errors) {
						commit("errors", resp.data.errors);
					} else if (resp.data && resp.data.length > 0) {
						commit("errors", null);
						commit("mSetDocks", resp.data);
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
			axios.post('/api/guestboatBerths', { ...data })
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
			axios.put('/api/guestboatBerths/' + data.id, { ...data })
				.then(resp => {
					if(resp.data.errors) {
						commit("errors", resp.data.errors);
					} else {
						commit("errors", null);
						commit("setSelected", resp.data);
						commit("updateSelected", resp.data);
					}
				}).catch(err => console.error(err));
		},
		detroy({ commit }, data) {
			axios.delete('/api/guestboatBerths/' + data.id)
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
		selectDock({ commit }, data) {
			commit("setSelectedDock", data);
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
