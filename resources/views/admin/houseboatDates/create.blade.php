@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link href="{{ route('admin.houseboatDates.index', ['saison' => $modus ?? null]) }}"
                    icon="fas fa-backward" class="btn">zurück
        </x-nav-link>
        <div id="calendar" class="mt-3"></div>
        <x-form name="frm" method="post" action="{{ route('admin.houseboatDates.store') }}" class="w-full lg:w-1/2">
            <x-form-select class="calc" class="houseboat" id="houseboat_id" name="houseboat_id" label="Hausboot"
                           :options="$houseboatOptions" required/>
            <x-form-input class="calc" id="from" name="from" type="date" label="Von" required/>
            <x-form-input class="calc" id="until" name="until" type="date" label="Bis" required/>
            <x-form-input id="price" name="price" type="number" min="0" label="Gesamt-Preis" required/>
            <x-form-input type="hidden" name="prices"/>
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">
                    Speichern
                </x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

@push('inline-scripts')
    <script>
    </script>
@endpush
