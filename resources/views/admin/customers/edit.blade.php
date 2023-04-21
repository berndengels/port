@extends('layouts.main')

@section('main')
    <div>
        <x-btn-back route="{{ route('admin.customers.' . (isset($route) ? $route : 'index')) }}" />
        <x-form :action="route('admin.customers.update', $customer)" class="w-half mt-3">
            @method('put')
            <input type="hidden" name="confirmed_old" value="{{ $confirmed ? 1 : 0 }}"/>
            @bind($customer)
            @can('confirm Registration')
            <div class="mt-3 bg-green p-3 text-white">
                <x-form-checkbox name="confirmed" label="Als Kunde bestätigt" class="mb-0 pb-0" />
            </div>
            @endcan
            @can('write Role')
                <x-form-select name="roles[]" label="Role" :options="$roles" many-relation multiple />
            @endcan
            <x-form-select name="type" label="Typ" :options="$customerTypes" required />
            <x-form-input name="name" label="Name" required />
            <x-form-input type="email" name="email" label="Email" required />
            <x-form-input type="password" name="password" label="Passwort" :bind="false" autocomplete="off" readonly
                onfocus="this.removeAttribute('readonly');" />
            <x-form-input type="password" name="password_confirmation" label="Passwort wiederholen" autocomplete="off" />

            <x-form-input name="fon" type="tel" label="Telefon" />
            <x-form-input name="city" label="Ort" />
            <x-form-input name="postcode" label="PLZ" />
            <x-form-input name="street" label="Strasse u. Hausnummer" />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

