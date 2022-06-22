import * as geolib from 'geolib'
import * as turf from 'turf'

class Geo {
	findEquidistantPoints(latLng1, latLng2, pointCount) {

		if (pointCount < 0) {
			throw IllegalArgumentException("PointCount cannot be less than 0")
		}

		let points = [],
			displacement = latLng1.displacementFromInMeters(latLng2),
			distanceBetweenPoints = displacement / (pointCount + 1),
			i;

		for (i in 1..pointCount) {
			let t = (distanceBetweenPoints * i) / displacement;

			points.push(LatLng(
				(1 - t) * latLng1.latitude + t * latLng2.latitude,
				(1 - t) * latLng1.longitude + t * latLng2.longitude
			))
		}

		return points
	}

	measure(lat1, lon1, lat2, lon2) {  // generally used geo measurement function
		var R = 6378.137; // Radius of earth in KM
		var dLat = lat2 * Math.PI / 180 - lat1 * Math.PI / 180;
		var dLon = lon2 * Math.PI / 180 - lon1 * Math.PI / 180;
		var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
			Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
			Math.sin(dLon/2) * Math.sin(dLon/2);
		var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
		var d = R * c;
		return d * 1000; // meters
	}
}
export default Geo;
