@extends('layouts.main')

@section('main')
    <div>
        <x-btn-back route="{{ route('admin.users.index') }}" />
        <x-form :action="route('admin.users.update', $user)" class="w-half mt-3">
            @method('put')
            @bind($user)
            <x-form-input name="name" label="Name" required />
            <x-form-input type="email" name="email" label="Email" required />
            <x-form-input name="fon" label="Mobiltelefon" />
            <x-form-input type="password" name="password" label="Passwort" :bind="false" autocomplete="off" readonly
                onfocus="this.removeAttribute('readonly');" />
            <x-form-input type="password" name="password_repeat" label="Passwort wiederholen" />
            @can('write Role')
            <x-form-select name="roles[]" label="Role" :options="$roles" many-relation multiple />
            @endcan
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

