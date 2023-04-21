@extends('layouts.main')

@section('main')
    <div>
        <x-btn-back route="{{ route('admin.config.saisonRentDates.index') }}" />
        <x-form class="w-half mt-3" method="post" :action="route('admin.config.saisonRentDates.update', $saisonRentDate)">
            @method('put')
            @bind($saisonRentDate)
            <x-form-select name="config_saison_rent_id" label="Rent Saison" :options="$saisonRents" required />
            <x-form-input type="text" id="name" name="name" label="Name" placeholder="z.B Jahreszahl" />
            <x-form-input type="text" class="mt-2" id="holiday" name="holiday" label="Name Feiertag" placeholder="z.B Feiertag mit Jahreszahl" />
            <x-form-input type="date" id="from" name="from" :bind="false" :default="$saisonRentDate->validFrom" label="Von" required />
            <x-form-input type="date" id="until" name="until" label="Bis" :bind="false" :default="$saisonRentDate->validUntil" required />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

