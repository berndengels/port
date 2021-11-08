@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.users.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form method="post" :action="route('admin.users.store')" class="w-full lg:w-1/2">
            <x-form-input name="name" label="Name" required />
            <x-form-input type="email" name="email" label="Email" required />
            <x-form-input name="fon" label="Mobiltelefon" />
            <x-form-input type="password" name="password" label="Passwort" required />
            <x-form-input type="password" name="password_repeat" label="Passwort wiederholen" required />
            @can('write Role')
            <x-form-select name="roles[]" label="Role" :options="$roles" multiple />
            @endcan
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

