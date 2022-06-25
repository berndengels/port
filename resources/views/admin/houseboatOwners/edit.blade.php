@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.houseboatOwners.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form name="frm" method="post" :action="route('admin.houseboatOwners.update', $houseboatOwner)" class="w-full lg:w-1/2">
            @method('put')

            @bind($houseboatOwner)
            <x-form-input name="name" label="Name" required />
            <x-form-input name="email" type="email" label="Email" required />
            <x-form-input name="fon" label="Telefon" required />
            <x-form-input name="postcode" label="PLZ" required />
            <x-form-input name="city" label="Ort/Stadt" required />
            <x-form-input name="street" label="Straße" required />
            <x-form-input name="bank" label="Bankverbindung" required />
            <x-form-input name="iban" label="IBAN" required />
            <x-form-input name="bic" label="BIC" required />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection
