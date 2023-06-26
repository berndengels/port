@extends('layouts.main')

@push('styles')
	<!--link rel="stylesheet" href="{{ asset('dropzone/dropzone.css') }}" type="text/css"/-->
@endpush()

@section('main')
	<div class="container-fluid">
		<x-btn-back route="{{ route('admin.boats.index') }}"/>
		<x-form id="frm" name="frm" method="post" :action="route('admin.boats.update', $boat)" class="mt-3" enctype="multipart/form-data">
			@method('put')
			<div class="row">
				<div class="col-sm-12 col-lg-6">
					<h5>Eigner Daten</h5>
					@bind($boat->customer)
					<x-form-input floating name="name" label="Eigner" required autocomplete="off"/>
					<ul id="customers" class="d-none w-100 autocomplete"></ul>
					<x-form-input floating name="email" label="Email"/>
					<x-form-input floating name="fon" label="Telefon"/>
					<x-form-input floating name="state" label="Bundesland"/>
					@endbind
					<h5 class="mt-3">Boots Daten</h5>
					@bind($boat)
					<x-form-select floating class="mt-1" name="berth_id" label="Liegplatz" :options="$berthOptions"/>
					<x-form-select floating name="type" label="Typ" :options="$types" required/>
					<x-form-input floating name="name" label="Boots Name" required/>
					<x-form-input floating name="length" type="number" step="0.1" min="1" label="Boots Länge" required/>
				</div>
				<div class="col-sm-12 col-lg-6">
					<x-form-input floating name="width" type="number" step="0.1" min="1" label="Boots Breite" required/>
					<x-form-input floating name="weight" type="number" min="1" label="Boots Gewicht in Kg"
								  placeholder="Gewicht in Kilogramm" required/>
					<x-form-input floating name="board_height" type="number" min="0" step="0.1" label=""
								  placeholder="Bord Höhe über Wasserlinie" required/>
					<x-form-input floating name="mast_length" type="number" step="1" min="0" label="Mastlänge"/>
					<x-form-input floating name="mast_weight" type="number" step="1" min="0" label="Mastgewicht in Kg"
								  placeholder="Gewicht in Kilogramm"/>
					<x-form-input floating name="draft" type="number" step="0.1" min="0.1" label="Tiefgang" required/>
					<x-form-input floating name="length_waterline" type="number" step="0.1" min="0.1" label="Länge Wasserlinie"
								  required/>
					<x-form-input floating name="length_keel" type="number" step="0.1" min="0" label="Kiellänge"/>
					@endbind
				</div>
			</div>

			@can('ImageUpload')
			<div class="row">
				<div class="col-12">
					<x-dropzone name="image" />
				</div>
			</div>
			@endcan

			<div class="row mt-2 ms-2">
				<x-form-submit class="col-1 btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection

@push('inline-scripts')
<script type="module">
	$(document).ready(() => {
		const frm = document.frm,
			options = {!! $customerOptions !!},
			route = "{{ route('admin.upload.image.boat', $boat) }}",
			files = {!! $files !!},
			bindings = {
				name: frm.name,
				email: frm.email,
				fon: frm.fon,
				state: frm.state,
			};
		MyForm.autocomplete(".autocomplete", frm.name, options, 'name', bindings);
		MyDropzone.create("#dropzone", 'image', route, files);
	})
</script>
@endpush
