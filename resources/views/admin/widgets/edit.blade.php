@extends('layouts.main')

@push('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('froala-editor/css/froala_editor.pkgd.min.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('froala-editor/css/third_party/font_awesome.min.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('froala-editor/css/plugins/code_view.min.css') }}"/>
@endpush

@push('scripts')
	<script src="{{ asset('froala-editor/js/froala_editor.pkgd.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('froala-editor/js/plugins/file.min.js') }}"></script>
	<script src="{{ asset('froala-editor/js/third_party/font_awesome.min.js') }}"></script>
@endpush

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.widgets.index') }}"/>
		<x-form name="frm" action="{{ route('admin.widgets.update', $widget) }}" class="w-half mt-3">
			@method('put')
			@bind($widget)
			<x-form-input name="position" label="Position" required/>
			<x-form-input name="title" label="Titel" required/>
			<x-form-input name="slug" label="slug"/>
			<x-form-input name="class" label="CSS Klasse"/>
			<x-form-input type="color" name="bgColor" label="Hintergrund-Farbe"/>
			<x-form-input type="color" name="color" label="Text-Farbe"/>
			<x-form-input type="hidden" name="content"/>
			<div id="froala-editor" class="mt-2">
				{!! $widget->content !!}
			</div>
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
			@endbind
		</x-form>
	</div>
@endsection

@push('inline-scripts')
	<script>
		const uploadUrl = '{{ route('admin.upload.image', ['paramName' => 'image']) }}';
		var editor = Editor.create('#froala-editor', 'image', uploadUrl);
		document.frm.onsubmit = (e) => {
			document.frm.content.value = editor.html.get(true);
			return true;
		};
	</script>
@endpush
