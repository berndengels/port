@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.caravans.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form method="post" :action="route('admin.caravans.store')" class="w-full lg:w-1/2">
            <x-form-select name="country_id" label="Herkunftsland" :options="$countries" default="55" />
            <x-form-input name="carnumber" label="Autokennzeichen" required />
            <x-form-input name="carlength" label="Länge" required />
            <x-form-input type="email" name="email" label="Email" />
            <x-form-submit class="rounded">Speichern</x-form-submit>
        </x-form>
    </div>
@endsection

