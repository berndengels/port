@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.users.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form :action="route('admin.users.update', $user)" class="w-full lg:w-1/2">
            @method('put')
            @bind($user)
            <x-form-input name="name" label="Name" required />
            <x-form-input type="email" name="email" label="Email" required />
            <x-form-input type="password" name="password" label="Passwort" />
            <x-form-input type="password" name="password_repeat" label="Passwort wiederholen" />
            <x-form-select name="roles[]" label="Role" :options="$roles" many-relation multiple />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

