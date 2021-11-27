import Vuex from 'vuex';
import caravan from "./modules/caravan";
import stats from "./modules/stats";

export default new Vuex.Store({
	modules: {
		caravan, stats
	},
	strict: process.env.NODE_ENV !== 'production',
});
