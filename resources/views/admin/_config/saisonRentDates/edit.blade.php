@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.config.saisonDates.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form method="post" :action="route('admin.config.saisonDates.update', $saisonRentDate)" class="w-full lg:w-1/2">
            @method('put')
            @bind($saisonRentDate)
            <x-form-select name="config_saison_rent_id" label="Rent Saison" :options="$saisonRents" required />
            <x-form-input type="date" id="from" name="from" min="{{ \Carbon\Carbon::today()->format('Y') }}-01-01" max="{{ \Carbon\Carbon::today()->addYear()->format('Y-m-d') }}" label="Von" required />
            <x-form-input type="date" id="until" name="until" min="{{ \Carbon\Carbon::today()->format('Y') }}-01-01" max="{{ \Carbon\Carbon::today()->addYear()->format('Y-m-d') }}" label="Bis" required />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

