@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.guestBoats.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form name="frm" method="post" :action="route('admin.guestBoats.update', $guestBoat)" class="w-full lg:w-1/2">
            @method('put')
            @bind($guestBoat)
            <x-form-input name="name" label="Boots Name" placeholder="Boots Name" required />
            <x-form-input name="length" type="number" step="1" min="1" label="Boots Länge" placeholder="Boots Länge" required />
            <x-form-input name="home_port" label="Heimathafen" placeholder="Ihr Heimathafen" />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

