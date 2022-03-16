@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.config.offers.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form name="frm" method="post" :action="route('admin.config.offers.store', $boat)" class="w-full lg:w-1/2">
            <x-form-input name="name" label="Name" placeholder="Angebots Name" required />
            <x-form-checkbox name="enabled" label="Eingeschalet" class="mb-0 pb-0" />
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection
