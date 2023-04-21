@extends('layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('froala-editor/css/froala_editor.pkgd.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('froala-editor/js/froala_editor.pkgd.min.js') }}"></script>
@endpush

@section('main')
    <div>
        <x-btn-back route="{{ route('admin.pages.index') }}" />
        <x-form method="post" :action="route('admin.pages.store')" class="w-half mt-3">
            <x-form-input name="title" label="Titel" required />
            <x-form-input name="slug" label="slug" required />
            <x-form-textarea id="content" name="content" label="Content" required />
            <div class="mt-2">
                <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

@push('inline-scripts')
<script>
$(document).ready(() =>{
    Editor.create('#content')
});
</script>
@endpush
