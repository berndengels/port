<script>
	var calendar;
	document.addEventListener('DOMContentLoaded', function () {
		var calendarEl = document.getElementById('calendar-{{ $id }}'),
			calendar = new FullCalendar.Calendar(calendarEl,
					{!! $options !!},
			);
		calendar.on('select', function (info) {
			let endStr = moment(info.end).subtract(1, 'day').format('YYYY-MM-DD'),
				startStr = info.startStr;
			if ($('#from').is(':visible')) {
				$('#from').val(startStr);
			}
			if ($('#until').is(':visible')) {
				$('#until').val(endStr);
			}
		});
		calendar.render();
	});
</script>
