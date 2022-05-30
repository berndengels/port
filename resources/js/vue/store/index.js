import Vuex from 'vuex';
import caravan from "./modules/caravan";
import houseboat from "./modules/houseboat";
import stats from "./modules/stats";

export default new Vuex.Store({
	modules: { caravan, stats, houseboat },
	strict: process.env.NODE_ENV !== 'production',
});
