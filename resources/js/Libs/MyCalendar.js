
import { Calendar } from '@fullcalendar/core';
//import interactionPlugin from '@fullcalendar/interaction'
import dayGridPlugin from '@fullcalendar/daygrid';
import momentTimezonePlugin from '@fullcalendar/moment-timezone';
import timeGridPlugin from '@fullcalendar/timegrid';
//import listPlugin from '@fullcalendar/list';

class MyCalendar {
	options = {
		plugins: [ dayGridPlugin, timeGridPlugin, momentTimezonePlugin ],
		locale: 'de',
		timeZone: 'Europe/Berlin',
		initialView: 'dayGridMonth',
		eventStartEditable: false,
		eventResizableFromStart: false,
		eventDurationEditable: false,
		durationEditable: false,
		selectable: false,
		expandRows: true,
		displayEventTime: false,
		firstDay: 1,
		contentHeight: '350px',
		aspectRatio: 1,
		headerToolbar: {
			left: 'prev,next today',
			center: 'title',
			right: 'dayGridMonth,timeGridWeek'
		},
	};
	houseboats(calendarSelector, dates, customOptions = null) {
		if(customOptions) {
			this.options = { ...this.options, ...customOptions }
		}
		console.info(dates);
		this.options.events = dates;

		const calendar = new Calendar(calendarSelector, this.options);
		calendar.render();
/*
		calendar.on('select', (info) => {
			console.info("on select: start ", info.startStr);
			console.info("on select: end ", info.end);
			let $from  = $('#from'),
				$until = $('#until'),
				startStr = info.startStr,
				endStr = info.endStr;
//				endStr = moment(info.end).subtract(12, 'hours').format('YYYY-MM-DD');

			if($from.is(':visible')) {
				$from.val(startStr);
				$from.trigger('change')
			}
			if($until.is(':visible')) {
				$until.val(endStr);
				$until.trigger('change')
			}
		});
*/
		return calendar;
	}
}
export default MyCalendar
