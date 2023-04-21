@extends('layouts.main')

@section('main')
    <div>
        <x-btn-back route="{{ route('admin.config.saisonRentDates.index') }}" />
        <x-form method="post" :action="route('admin.config.saisonRentDates.store')" class="w-half mt-3">
            <x-form-select name="config_saison_rent_id" label="Rent Saison" :options="$saisonRents" required />
            <x-form-select id="config_holiday" name="config_holiday" label="Feiertage" :options="$holidayOptions" />
            <x-form-input type="text" id="name" name="name" label="Name" placeholder="z.B Jahreszahl" />
            <x-form-input type="date" id="from" name="from" min="{{ \Carbon\Carbon::today()->format('Y') }}-01-01" label="Von" required />
            <x-form-input type="date" id="until" name="until" min="{{ \Carbon\Carbon::today()->format('Y') }}-01-01" label="Bis" required />
            <x-form-input type="hidden" id="holiday" name="holiday" />
            <div class="mt-2">
                <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

@push('inline-scripts')
    <script>
        var $from = $('#from'),$until = $('#until'), $holiday = $('#holiday');
		$(document).ready(() => {
            $('#config_holiday').change(e => {
                let values = $(e.target).val().split('|');
	            $holiday.val(values[0]);
				$from.val(values[1]);
				$until.val(values[2]);
            });
		})
    </script>
@endpush


