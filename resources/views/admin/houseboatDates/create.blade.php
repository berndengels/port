@extends('layouts.main')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.css"/>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.min.js"></script>
@endpush

@section('main')
    <div class="mt-5 ml-5 w-1/4">
        <x-nav-link href="{{ route('admin.houseboatDates.index', ['saison' => $modus ?? null]) }}"
                    icon="fas fa-backward" class="btn">zurück
        </x-nav-link>
    </div>
    <div class="p-6 flex">
        <div class="flex-auto w-64">
            <x-form name="frm" method="post" action="{{ route('admin.houseboatDates.store') }}" class="w-full lg:w-1/2">
                <x-form-select class="calc" class="houseboat" id="houseboat_id" name="houseboat_id" label="Hausboot"
                               :options="$houseboatOptions" required/>
                <x-form-select class="calc" class="customer" id="customer_id" name="customer_id" label="Gast"
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
        <div class="flex-auto w-64">
            <div id="calendar">
                {!! $calendar->calendar() !!}
                {!! $calendar->script() !!}
            </div>
        </div>
    </div>
@endsection

@push('inline-scripts')
    <script>
    </script>
@endpush
