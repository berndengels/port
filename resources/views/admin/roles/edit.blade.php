@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.roles.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form method="post" :action="route('admin.roles.update', $role)" class="w-full lg:w-1/2">
            @method('put')
            @bind($role)
            <x-form-input name="name" label="Name" required />
            <x-form-select name="guard_name" label="Guard Name" :options="$guards" required />
            <x-form-select name="permissions[]" :options="$permissions" class="flexy" size="10" many-relation multiple />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

