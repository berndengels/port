const WeatherMethods = {
	data() {
		return {
			weatherData: null,
			weatherDataLoaded: false,
		}
	},
	methods: {
		msToKmh(metersPerSecond) {
			return Math.round(metersPerSecond * 3.6);
		},
		convertDegreesToWindDirection(degrees) {
			let directions = ['N', 'NNO', 'NO', 'ONO', 'O', 'OSO', 'SO', 'SSO', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW', 'N'];
			return directions[Math.round(degrees / 22.5)];
		},
		msToBft(ms) {
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
		zeroFill (val) {
			return (val < 10 ? '0' : '') + val;
		}
	}
}
export default WeatherMethods;
