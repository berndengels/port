import { createStore } from 'vuex';
import offers from "./modules/offers";
import caravan from "./modules/caravan";
import rentals from "./modules/rentals";
import stats from "./modules/stats";
import berth from "./modules/berth";
import weather from "./modules/weather";

export default createStore({
	modules: { offers, caravan, stats, rentals, berth, weather },
	strict: process.env.NODE_ENV !== 'production',
});
