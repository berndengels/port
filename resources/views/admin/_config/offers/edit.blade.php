@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.config.offers.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form name="frm" method="post" :action="route('admin.config.offers.update', $offer)" class="w-full lg:w-1/2">
            @method('put')
            @bind($offer)
            <x-form-input name="name" label="Name" placeholder="Angebots Name" required />
            <x-form-checkbox name="enabled" label="Eingeschalet" class="mb-0 pb-0" />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection
