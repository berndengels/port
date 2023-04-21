
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import momentTimezonePlugin from '@fullcalendar/moment-timezone';
import timeGridPlugin from '@fullcalendar/timegrid';

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
		expandRows: false,
		displayEventTime: false,
		firstDay: 1,
		contentWidth: '90%',
		contentHeight: '350px',
		aspectRatio: 1,
		headerToolbar: {
			left: 'prev,next today',
			center: 'title',
			right: 'dayGridMonth,timeGridWeek'
		},
	};
	rentals(calendarSelector, dates, customOptions = null) {
		if(customOptions) {
			this.options = { ...this.options, ...customOptions }
		}
		this.options.events = dates;

		const calendar = new Calendar(calendarSelector, this.options);
		calendar.render();
		return calendar;
	}
}
export default MyCalendar
