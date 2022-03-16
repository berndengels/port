@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.houseboats.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form name="frm" method="post" :action="route('admin.houseboats.store')" class="w-full lg:w-1/2">
            <x-form-input name="name" label="Name" placeholder="Hausboot Name" required />
            <x-form-select name="houseboat_model_id" label="Modell" :options="$models" required />
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection
