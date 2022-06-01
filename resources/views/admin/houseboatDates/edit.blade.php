@extends('layouts.main')

@section('main')
    <div class="mt-5 ml-5 w-1/4">
        <x-nav-link href="{{ route('admin.houseboatDates.index', ['saison' => $modus ?? null]) }}"
                    icon="fas fa-backward" class="btn">zurück
        </x-nav-link>
    </div>
    <div class="p-6 flex">
        <div class="flex-auto w-3/12">
            <x-form name="frm" method="post" :action="route('admin.houseboatDates.update', $houseboatDate)" class="w-full">
                @method('put')
                <div class="mt-1">
                    <span class="text-xl text-blue-900">Hausboot: {{ $houseboatDate->houseboat->name }}</span>
                </div>
                <div class="mt-5 mb-5">
                    <span class="text-xl text-blue-900">Gast: {{ $houseboatDate->customer->name }}, {{ $houseboatDate->customer->email }}</span>
                </div>
                <input type="hidden" class="calc" id="houseboat_id" name="houseboat_id" value="{{ $houseboatDate->houseboat_id }}" />
                @bind($houseboatDate)
                <x-form-checkbox id="is_paid" name="is_paid" label="Ist Bezahlt" class="mb-0 pb-0" />
                <x-form-input class="calc" id="from" name="from" type="date" label="Von" required />
                <x-form-input class="calc" id="until" name="until" type="date" label="Bis" required />
                <x-form-input  id="price" name="price" type="number" min="0" label="Gesamt-Preis" required />
                <x-form-input type="hidden" name="prices" />
                @endbind
                <div class="mt-2">
                    <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
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
	        id          = {{ $houseboatDate->id }},
	        dates       = {!! $calendarDates !!},
	        initialDate = "{{ $initialDate }}",
	        calendar    = MyCalendar.houseboats(elCalendar, dates, {
				initialDate: initialDate,
                dateId: id,
			}),
	        events      = calendar.getOption('events'),
	        event       = calendar.getEventById(id);

        let $from   = $('#from'),
	        $until  = $('#until');

        if($from.is(':visible')) {
            $from.change(e => {
				let val = $(e.target).val();
	            val = moment(val).add(12, 'hours').format('YYYY-MM-DD HH:00:00');
                event.setStart(val)
            })
        }
        if($until.is(':visible')) {
            $until.change(e => {
	            let val = $(e.target).val();
				val = moment(val).add(12, 'hours').format('YYYY-MM-DD HH:00:00');
				console.info(val);
	            event.setEnd(val)
            })
        }
        const calcUrl = "{{ route('admin.houseboatDates.price.calculate') }}";
        Prices.houseboatDates.calculate(document.frm, calcUrl);
    </script>
@endpush
