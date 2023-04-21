@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-btn-back route="{{ route('admin.serviceCategories.index') }}" />
        <x-form method="post" :action="route('admin.serviceCategories.update', $serviceCategory)" class="w-half mt-3">
            @method('put')
            @bind($serviceCategory)
            <x-form-input name="name" label="Name" required />
            <x-form-select name="modus" label="Modus/Art" :options="$modi" required />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

