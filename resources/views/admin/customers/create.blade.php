@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.customers.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form method="post" :action="route('admin.customers.store')" class="w-full lg:w-1/2">
            <x-form-select name="customer_type" label="Typ" :options="$customerTypes" required />
            <x-form-input name="name" label="Name" required />
            <x-form-input type="email" name="email" label="Email" required />
            <x-form-input type="password" name="password" label="Passwort" required />
            <x-form-input type="password" name="password_confirmation" label="Passwort wiederholen" required />
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

