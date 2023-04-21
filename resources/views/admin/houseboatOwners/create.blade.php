@extends('layouts.main')

@section('main')
    <div>
        <x-btn-back route="{{ route('admin.houseboatOwners.index') }}" />
        <x-form name="frm" method="post" :action="route('admin.houseboatOwners.store')" class="w-half mt-3">
            <x-form-input name="name" label="Name" required />
            <x-form-input name="email" type="email" label="Email" required />
            <x-form-input name="fon" label="Telefon" required />
            <x-form-input name="postcode" label="PLZ" required />
            <x-form-input name="city" label="Ort/Stadt" required />
            <x-form-input name="street" label="Straße" required />
            <x-form-input name="bank" label="Bankverbindung" required />
            <x-form-input name="iban" label="IBAN" required />
            <x-form-input name="bic" label="BIC" required />
            <div class="mt-2">
                <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection
