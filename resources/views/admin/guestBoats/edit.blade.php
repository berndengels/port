@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-btn-back route="{{ route('admin.guestBoats.index') }}" />
        <x-form name="frm" method="post" :action="route('admin.guestBoats.update', $guestBoat)" class="w-half mt-3">
        @method('put')
            @bind($guestBoat)
            <x-form-input name="name" label="Name" placeholder="Boots Name" required />
            <x-form-input name="length" label="Länge" placeholder="Boots Länge" required />
            <x-form-input name="home_port" label="Heimathafen" placeholder="Heimathafen" required />
            <x-form-input name="email" type="email" label="Email" placeholder="Email-Adresse" />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

