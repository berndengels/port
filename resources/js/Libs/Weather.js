var msToKmh = (metersPerSecond) => {
	return Math.round(metersPerSecond * 3.6);
}
var convertDegreesToWindDirection = (degrees) => {
	let directions = ['N', 'NNO', 'NO', 'ONO', 'O', 'OSO', 'SO', 'SSO', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW', 'N'];
	return directions[Math.round(degrees / 22.5)];
}
/*
m/s 	        km/h 	    Knoten 	    Bezeichnung 	Beaufort
unter 0,3 	    unter 1 	unter 1 	Windstille 	        0
0,3 - 1,5 	    1 - 5 	    1 - 3 	    Schwacher Wind 	    1
1,6 - 3,3 	    6 - 11 	    4 - 6 	    Schwacher Wind 	    2
3,4 - 5,4 	    12 - 19 	7 - 10 	    Schwacher Wind 	    3
5,5 - 7,9 	    20 - 28 	11 - 15 	Mäßiger Wind 	    4
8,0 - 10,7 	    29 - 38 	16 - 21 	Frischer Wind 	    5
10,8 - 13,8 	39 - 49 	22 - 27 	Starker Wind 	    6
13,9 - 17,1 	50 - 61 	28 - 33 	Steifer Wind 	    7
17,2 - 20,7 	62 - 74 	34 - 40 	Stürmischer Wind 	8
20,8 - 24,4 	75 - 88 	41 - 47 	Sturm 	            9
24,5 - 28,4 	89 - 102 	48 - 55 	Schwerer Sturm 	    10
28,5 - 32,6 	103 - 117 	56 - 63 	Orkanartiger Sturm 	11
über 32,7 	    über 118 	über 64 	Orkan 	            12
*/
var msToBft = (ms) => {
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
}
var display = (selector, data) => {
	const
		$weatherTitle = $('.weatherTitle'),
		$wrapper = $(selector),
		$div=$('<div>'),
		skipLabels=['Name','Beschreibung','Bild']
	;
	$('.weatherTitle').append(" für "+ data.Name);
	for(const [k,v] of Object.entries(data)) {
		let $row = $div.clone().addClass(k.toLowerCase()),
			$label = $div.clone().html(k),
			$text = $div.clone().html(v)
		;
		if('Name' === k) {
			continue;
		}
		if(-1 === $.inArray(k, skipLabels)) {
			$row.append($label)
		}
		$row.append($text);
		$row.appendTo($wrapper);
	}
}
var zeroFill = (val) => {
	return (val < 10 ? '0' : '') + val;
}
class Weather {
	get(selector) {
		const lat = process.env.MIX_POSITION_LAT,
			lng = process.env.MIX_POSITION_LNG,
			apiURL = process.env.MIX_WEATHER_API_URL + process.env.MIX_WEATHER_API_KEY,
			iconURL = process.env.MIX_WEATHER_API_ICON_URL,
			url = apiURL.replace("%LAT%", lat).replace("%LNG%", lng),
			$img = $('<img>')
		;
		$.ajax({
			url: url,
			success: function( r ) {
				let iconUrl = iconURL.replace("%ICON%", r.weather[0].icon),
					dateSunrise = new Date(r.sys.sunrise * 1000),
					dateSunset  = new Date(r.sys.sunset * 1000),
					result = {
						Name:                   r.name,
						Bild:                   $img.attr({src: iconUrl}),
						Beschreibung:           r.weather[0].description,
						Temperatur:             Math.round(r.main.temp) + "° Celsius",
						Sonnenaufgang:          dateSunrise.getHours() + ":" + zeroFill(dateSunrise.getMinutes()) + " Uhr",
						Sonnenuntergang:        dateSunset.getHours() + ":" + zeroFill(dateSunset.getMinutes()) + " Uhr",
						Windrichtúng:           convertDegreesToWindDirection(r.wind.deg),
						Windgeschwindigkeit:    msToBft(r.wind.speed) + " Bft",
					};
				display(selector, result);
			}
		});
	}
}

export default Weather;
