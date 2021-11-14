@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.pages.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form action="{{ route('admin.pages.update', $page) }}" class="w-full lg:w-1/2">
            @method('put')
            @bind($page)
            <x-form-input name="title" label="Titel" required />
            <x-form-input name="slug" label="slug" required />
            <x-form-input name="content" label="Content" required />
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
            @endbind
        </x-form>
    </div>
@endsection

