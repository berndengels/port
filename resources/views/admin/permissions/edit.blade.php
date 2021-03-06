@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.permissions.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <h3 class="mt-3 text-green-800">Name: {{ $permission->name }}</h3>
        <x-form method="post" :action="route('admin.permissions.update', $permission)" class="w-full lg:w-1/2">
            @method('put')
            @bind($permission)
            <x-form-select name="model" label="Model" :options="$models" required />
            <x-form-select name="action" label="Aktion" :options="$actions" required />
            <x-form-input name="name" label="Eigener Name" placeholder="Eigener Name" />
            <x-form-input name="guard_name" label="Guard Name" placeholder="Guard Name" required />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

