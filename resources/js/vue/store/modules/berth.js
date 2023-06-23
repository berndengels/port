const namespaced = true,
	state = {
		data: null,
		docks: null,
		portData: null,
		categories: null,
		selected: null,
		selectedDock: null,
		errors: null,
		calcData: {
			modus: "1",
			berth_category_id: 1,
			dock_id: 1,
			dock: null,
			enabled: true,
			start: 1,
			count: 10,
			width: null,
			length: 10,
			daily_price: null,
		},
		loading: true,
	},
	mutations = {
		setSelected: (state, data) => {
			state.selected = data;
//			console.info("selected", data);
//			emitter.emit('geoDataSelected', data)
		},
		setSelectedDock: (state, data) => {
			state.selectedDock = data;
//			emitter.emit('geoDockSelected', data)
		},
		mSetData: (state, data) => {
			state.data = data
			state.loading = false
		},
		mSetCategories: (state, data) => {
			state.categories = data
		},
		mSetPortData: (state, data) => {
			state.portData = data
		},
		mSetDocks: (state, data) => {
			state.docks = data
		},
		setCalcData: (state, data) => {
			state.calcData = data
		},
		mPushSelected: (state, data) => {
			if (state.data && state.data.length > 0) {
				data.forEach(el => state.data.push(el));
			} else {
				state.data = data
			}
//			emitter.emit('data:updated', {data: state.data})
		},
		destroySelected: (state, data) => {
			if (state.data && state.data.length > 0) {
				state.data = state.data.filter(b => b !== data)
			}
		},
		destroyAll: (state) => {
			if (state.data && state.data.length > 0) {
				state.data = null
			}
		},
		updateSelected: (state, data) => {
			state.data = state.data.map(b => b.id === data.id ? data : b)
		},
		updateFormSelected: (state, data) => {
			state.data = state.data.map(b => b.id === data.id ? data : b)
		},
		errors: (state, errors) => {
			state.errors = errors
		},
	},
	getters = {
		data: (state) => state.data,
		categories: (state) => {
			if (state.categories && state.categories.length > 0) {
				let data = state.categories.map(i => {
					return {"id": i.id, "name": i.name}
				});
				data.unshift({id: "", name: "bitte wählen"});
				return data;
			}
			return null;
		},
		portData: (state) => state.portData,
//		docks: (state) => state.docks,
		docks: (state) => {
			if (state.docks && state.docks.length > 0) {
				let data = state.docks.map(i => {
					return {"id": i.id, "name": i.name}
				});
				data.unshift({id: "", name: "bitte wählen"});
				return data;
			}
			return null;
		},
		docksOptions: (state) => {
			if (state.docks && state.docks.length > 0) {
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
		fetchData({commit}) {
			axios.get('/api/berths')
				.then(resp => {
					if (resp.data.errors) {
						commit("errors", resp.data.errors);
					} else if (resp.data && resp.data.length > 0) {
						commit("errors", null);
						commit("mSetData", resp.data);
					} else {
						commit("errors", null);
					}
				}).catch(err => console.info("error", err));
		},
		loadBackup({commit}) {
			axios.get('/api/berths/laodBackup')
				.then(resp => {
					if (resp.data.errors) {
						commit("errors", resp.data.errors);
					} else if (resp.data && resp.data.length > 0) {
						commit("errors", null);
						commit("mSetData", resp.data);
					} else {
						commit("errors", null);
					}
				}).catch(err => console.info("error", err));
		},
		saveBackup({commit}) {
			axios.get('/api/berths/saveBackup')
				.then(resp => {
					if (resp.data.errors) {
						commit("errors", resp.data.errors);
					} else if (resp.data && resp.data.length > 0) {
						commit("errors", null);
						commit("mSetData", resp.data);
					} else {
						commit("errors", null);
					}
				}).catch(err => console.info("error", err));
		},
		fetchCategories({commit}) {
			axios.get('/api/berths/categories')
				.then(resp => {
					if (resp.data.errors) {
						commit("errors", resp.data.errors);
					} else if (resp.data) {
						commit("errors", null);
						commit("mSetCategories", resp.data);
					} else {
						commit("errors", null);
					}
				}).catch(err => console.info("error", err));
		},
		fetchPortData({commit}) {
			axios.get('/api/berths/port')
				.then(resp => {
					if (resp.data.errors) {
						commit("errors", resp.port.errors);
					} else if (resp.data) {
						commit("errors", null);
						commit("mSetPortData", resp.data);
					} else {
						commit("errors", null);
					}
				}).catch(err => console.info("error", err));

		},
		fetchDocks({commit}) {
			axios.get('/api/berths/docks')
				.then(resp => {
					if (resp.data.errors) {
						commit("errors", resp.data.errors);
					} else if (resp.data && resp.data.length > 0) {
						commit("errors", null);
						commit("mSetDocks", resp.data);
					} else {
						commit("errors", null);
					}
				}).catch(err => console.info("error", err));

		},
		refill({commit}, data) {
			axios.post('/api/berths/refill', data)
				.then(resp => {
					if (resp.data.errors) {
						commit("errors", resp.data.errors);
					} else if (resp.data && resp.data.length > 0) {
						commit("errors", null);
						commit("mSetData", resp.data);
					} else {
						commit("errors", null);
					}
				}).catch(err => console.error(err));
		},
		store({commit}, data) {
			axios.post('/api/berths', {...data})
				.then(resp => {
					if (resp.data.errors) {
						commit("errors", resp.data.errors);
					} else {
						commit("errors", null);
						commit("mPushSelected", resp.data);
					}
				}).catch(err => console.error(err));
		},
		update({commit}, data) {
			axios.put('/api/berths/' + data.id, {...data})
				.then(resp => {
					if (resp.data.errors) {
						commit("errors", resp.data.errors);
					} else {
						commit("errors", null);
						commit("setSelected", resp.data);
						commit("updateSelected", resp.data);
					}
				}).catch(err => console.error(err));
		},
		detroy({commit}, data) {
			axios.delete('/api/berths/' + data.id)
				.then(resp => {
					if (resp.data.errors) {
						commit("errors", resp.data.errors);
					} else {
						commit("errors", null);
						commit("destroySelected", resp.data);
					}
				}).catch(err => console.error(err));
		},
		setPoints({commit}, data) {
			axios.post('/api/berths/setPoints', {points: data})
				.then(resp => {
					if (resp.data.errors) {
						commit("errors", resp.data.errors);
					} else {
						commit("errors", null);
//						commit("mSetData", resp.data);
					}
				}).catch(err => console.error(err));
		},
		detroyAny({commit}, data) {
			axios.post('/api/berths/batchDestroy', {any: data})
				.then(resp => {
					if (resp.data.errors) {
						commit("errors", resp.data.errors);
					} else {
						commit("errors", null);
						commit("mSetData", resp.data);
					}
				}).catch(err => console.error(err));
		},
		detroyAll({commit}) {
			axios.delete('/api/berths')
				.then(resp => {
					if (resp.data.errors) {
						commit("errors", resp.data.errors);
					} else {
						commit("errors", null);
						commit("destroyAll");
					}
				}).catch(err => console.error(err));
		},
		select({commit}, data) {
			commit("setSelected", data);
		},
		selectDock({commit}, data) {
			commit("setSelectedDock", data);
		},
		setCalcData({commit}, data) {
			commit("setCalcData", data);
		},
		setData({commit}, data) {
			commit("mSetData", data);
		},
		addData({commit}, data) {
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
