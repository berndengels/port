@extends('layouts.main')

@push('scripts')
	<script type="module" src="{{ asset('tinymce/tinymce.min.js') }}"></script>
@endpush

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.pages.index') }}"/>
		<x-form action="{{ route('admin.pages.update', $page) }}" class="w-half mt-3">
			@method('put')
			@bind($page)
			<x-form-input name="title" label="Titel" required/>
			<x-form-input name="slug" label="slug" required/>
			<x-form-textarea id="content" name="content" label="Content" required/>
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
			@endbind
		</x-form>
	</div>
@endsection

@push('inline-scripts')
	<script>
		$(document).ready(() => {
			Editor.create('#content')
		});
	</script>
@endpush
