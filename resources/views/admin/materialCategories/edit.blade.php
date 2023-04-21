@extends('layouts.main')

@section('main')
    <div>
        <x-btn-back route="{{ route('admin.materialCategories.index') }}" />
        <x-form method="post" :action="route('admin.materialCategories.update', $materialCategory)" class="w-half mt-3">
            @method('put')
            @bind($materialCategory)
            <x-form-input name="name" label="Name" required />
            <x-form-select name="modus" label="Modus/Art" :options="$modi" required />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

