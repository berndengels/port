try {
	window.$ = window.jQuery = require('jquery');
	const axios = require('axios');
	const moment = require('moment');

	axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
	axios.defaults.baseURL = process.env.MIX_API_URL;
//	axios.defaults.withCredentials = false;

	window.axios = axios;
	window.moment = moment;
} catch (e) {
	console.error(e)
}
