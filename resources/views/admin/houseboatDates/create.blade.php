@extends('layouts.main')

@section('main')
    <div class="mt-5 ml-5 w-1/4">
        <x-nav-link href="{{ route('admin.houseboatDates.index', ['saison' => $modus ?? null]) }}"
                    icon="fas fa-backward" class="btn">zurück
        </x-nav-link>
    </div>
    <div class="p-6 flex">
        <div class="flex-auto w-3/12">
            <x-form name="frm" method="post" action="{{ route('admin.houseboatDates.store') }}" class="w-full">
                <x-form-checkbox id="is_paid" name="is_paid" label="Ist Bezahlt" class="mb-0 pb-0" />
                <x-form-select class="calc" id="houseboat_id" name="houseboat_id" label="Hausboot"
                               :options="$houseboatOptions" required/>
                <x-form-select id="customer_id" name="customer_id" label="Gast"
                               :options="$customerOptions" required/>
                <x-form-input class="calc" id="from" name="from" type="date" label="Von" required/>
                <x-form-input class="calc" id="until" name="until" type="date" label="Bis" required/>
                <x-form-input id="price" name="price" type="number" min="0" label="Gesamt-Preis"/>
                <x-form-input type="hidden" name="prices"/>
                <div class="mt-2">
                    <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">
                        Speichern
                    </x-form-submit>
                </div>
            </x-form>
        </div>
        <div class="flex-auto w-9/12 ml-5">
            <div id="calendar"></div>
        </div>
    </div>
@endsection

@push('inline-scripts')
    <script>
	    const elCalendar = document.getElementById('calendar'),
		    dates       = {!! $calendarDates !!},
		    calendar    = MyCalendar.houseboats(elCalendar, dates),
		    events      = calendar.getOption('events'),
            id          = (new Date()).getTime()
        ;

	    let $from   = $('#from'),
		    $until  = $('#until'),
            event = null;
	    console.info(event);

	    if($from.is(':visible')) {
		    $from.change(e => {
			    let val = $(e.target).val();
                val = moment(val).add(12, 'hours').format('YYYY-MM-DD HH:00:00');
				if(!event) {
					event = calendar.addEvent({
						allDay: false,
						title: "Neueintrag",
						color: '#0a0',
						start: val,
					});
                }
			    event.setStart(val)
		    })
	    }
	    if($until.is(':visible')) {
		    $until.change(e => {
			    let val = $(e.target).val();
				val = moment(val).add(12, 'hours').format('YYYY-MM-DD HH:00:00');
				if(event) {
					event.setEnd(val)
                }
		    })
	    }
	    const calcUrl = "{{ route('admin.houseboatDates.price.calculate') }}";
	    Prices.houseboatDates.calculate(document.frm, calcUrl);
    </script>
@endpush
