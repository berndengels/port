@extends('layouts.main')

@section('main')
    <div>
        <x-btn-back route="{{ route('admin.houseRentals.index', ['saison' => $modus ?? null]) }}" />
        <div class="flex-row">
            <div class="flex-column">
                <x-form name="frm" method="post" :action="route('admin.houseRentals.update', $houseboatDate)" class="w-half mt-3">
                    @method('put')
                    <div class="my-1">
                        <span class="fs-5 blue">Hausboot: {{ $houseboatDate->houseboat->name }}</span>
                    </div>
                    <div class="my-1">
                        <span class="fs-5 blue">Gast: {{ $houseboatDate->customer->name }}, {{ $houseboatDate->customer->email }}</span>
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
                        <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
                    </div>
                </x-form>
            </div>
            <div class="flex-column">
                <div class="mt-2" id="calendar"></div>
            </div>
        </div>
    </div>
@endsection

@push('inline-scripts')
<script>
    $(document).ready(() => {
	    const elCalendar = document.getElementById('calendar'),
		    id          = {{ $houseboatDate->id }},
		    dates       = {!! $calendarDates !!},
		    initialDate = "{{ $initialDate }}",
		    calendar    = MyCalendar.houseboats(elCalendar, dates, {
			    initialDate: initialDate,
			    dateId: id,
		    }),
		    event   = calendar.getEventById(id),
	        $from   = $('#from'),
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
			    event.setEnd(val)
		    })
	    }
	    const calcUrl = "{{ route('admin.houseRentals.price.calculate') }}";
	    Prices.houseRentals.calculate(document.frm, calcUrl);
    });
</script>
@endpush
