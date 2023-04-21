@extends('layouts.main')

@section('main')
    <div>
        <x-btn-back route="{{ route('admin.docks.index') }}" />
        <x-form name="frm" method="post" :action="route('admin.docks.update', $dock)" class="w-half mt-3">
            @method('put')
            @bind($dock)
            <x-form-select name="name" label="Steg Nummer" :options="$dockNumbers" />
            <x-form-input name="length" type="number" step="1" min="1" label="Steg Länge" />
            <x-form-input name="min_box_length" type="number" step="1" min="1" label="min. Box-Länge" />
            <x-form-input name="max_box_length" type="number" step="1" min="1" label="max. Box-Länge" />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

