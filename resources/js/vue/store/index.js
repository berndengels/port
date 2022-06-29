import Vuex from 'vuex';
import offers from "./modules/offers";
import caravan from "./modules/caravan";
import houseboat from "./modules/houseboat";
import stats from "./modules/stats";
import guestboatBerth from "./modules/guestboatBerth";

export default new Vuex.Store({
	modules: { offers, caravan, stats, houseboat, guestboatBerth },
	strict: process.env.NODE_ENV !== 'production',
});
