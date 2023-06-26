import {createStore} from 'vuex';
import offers from "./modules/offers";
import caravan from "./modules/caravan";
import rentals from "./modules/rentals";
import stats from "./modules/stats";
import berth from "./modules/berth";
import weather from "./modules/weather";
import craneDates from "./modules/craneDates";

export default createStore({
	modules: {offers, caravan, stats, rentals, berth, weather, craneDates},
	strict: process.env.NODE_ENV !== 'production',
});
