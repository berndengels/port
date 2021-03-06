@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('customer.profile.show', $profile)" icon="fas fa-backward" class="btn">zurrück</x-nav-link>
        <x-form :action="route('customer.profile.update', $profile)" class="w-full lg:w-1/2 mt-3">
            @method('put')
            @bind($profile)
            <x-form-input name="name" label="Name" required />
            <x-form-input type="email" name="email" label="Email" required />
            <x-form-input type="password" name="password" label="Passwort" />
            <x-form-input type="password" name="password_confirmation" label="Passwort wiederholen" />

            <x-form-input name="fon" type="tel" label="Telefon" />
            <x-form-input name="city" label="Ort" />
            <x-form-input name="postcode" label="PLZ" />
            <x-form-input name="street" label="Strasse u. Hausnummer" />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

