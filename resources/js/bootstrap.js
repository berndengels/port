window._ = require('lodash');
window.dayjs = require('dayjs');
import 'dayjs/locale/de'
window.dayjs.locale('de');
var isBetween = require('dayjs/plugin/isBetween')
dayjs.extend(isBetween)

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.baseURL = process.env.MIX_API_URL;
