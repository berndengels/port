const msToKmh = (metersPerSecond) => {
	return Math.round(metersPerSecond * 3.6);
},
convertDegreesToWindDirection = (degrees) => {
	let directions = ['N', 'NNO', 'NO', 'ONO', 'O', 'OSO', 'SO', 'SSO', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW', 'N'];
	return directions[Math.round(degrees / 22.5)];
},
msToBft = (ms) => {
	var bft = 0;
	if(ms >= 32.7) {
		bft = 12;
	}
	else if(ms >= 28.5) {
		bft = 11;
	}
	else if(ms >= 24.5) {
		bft = 10;
	}
	else if(ms >= 20.8) {
		bft = 9;
	}
	else if(ms >= 17.2) {
		bft = 8;
	}
	else if(ms >= 13.9) {
		bft = 7;
	}
	else if(ms >= 10.8) {
		bft = 6;
	}
	else if(ms >= 8.0) {
		bft = 5;
	}
	else if(ms >= 5.5) {
		bft = 4;
	}
	else if(ms >= 3.4) {
		bft = 3;
	}
	else if(ms >= 1.6) {
		bft = 2;
	}
	else if(ms >= 0.3) {
		bft = 1;
	}
	return bft;
},
zeroFill = (val) => {
	return (val < 10 ? '0' : '') + val;
};

const namespaced = true,
	state = {
		data: {},
		loading: true,
	},
	mutations = {
		mData: (state, data) => {
			state.data = data
			state.loading = false
		},
	},
	getters = {
		data: (state) => state.data,
		loading: (state) => state.loading,
	},
	actions = {
		fetch({ commit }) {
			axios.get('api/weather')
				.then(resp => {
					if(!resp.data) {
						return false
					}
					const r = resp.data,
						dateSunrise = new Date(r.sys.sunrise * 1000),
						dateSunset  = new Date(r.sys.sunset * 1000),
						data = {
							Name:                   r.name,
							Beschreibung:           r.weather[0].description,
							Temperatur:             Math.round(r.main.temp) + "° Celsius",
							Sonnenaufgang:          dateSunrise.getHours() + ":" + zeroFill(dateSunrise.getMinutes()) + " Uhr",
							Sonnenuntergang:        dateSunset.getHours() + ":" + zeroFill(dateSunset.getMinutes()) + " Uhr",
							Windrichtúng:           convertDegreesToWindDirection(r.wind.deg),
							Windgeschwindigkeit:    msToBft(r.wind.speed) + " Bft",
							iconUrl: process.env.MIX_WEATHER_API_ICON_URL.replace("%ICON%", r.weather[0].icon),
						};
					commit('mData', data)
				})
				.catch(err=> console.error(err))
		}
	};
export default {
	namespaced,
	state,
	getters,
	mutations,
	actions
}
