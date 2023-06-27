@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.boats.index') }}"/>
		<x-form name="frm" method="post" :action="route('admin.boats.store')" class="mt-3">
			<div class="row">
				<div class="col-sm-12 col-lg-6">
					<h5>Eigner Daten</h5>
					<x-form-input floating id="autocomplete" name="name" label="Eigner" required autocomplete="off"/>
					<ul id="customers" class="d-none w-100 autocomplete"></ul>
					<x-form-input floating name="email" label="Email"/>
					<x-form-input floating name="fon" label="Telefon"/>
					<x-form-input floating name="state" label="Bundesland"/>
					<h5 class="mt-3">Boots Daten</h5>
					<x-form-select floating class="mt-1" name="berth_id" label="Liegplatz" :options="$berthOptions"/>
					<x-form-select floating name="type" label="Typ" :options="$types" required/>
					<x-form-input floating name="name" label="Boots Name" required/>
					<x-form-input floating name="length" type="number" step="0.1" min="1" label="Boots Länge in M" required/>
				</div>
				<div class="col-sm-12 col-lg-6 mt-4">
					<x-form-input floating name="width" type="number" step="0.1" min="1" label="Boots Breite in M" required/>
					<x-form-input floating name="weight" type="number" min="1" label="Boots Gewicht in Kg" required/>
					<x-form-input floating name="board_height" type="number" min="0" step="0.1" label="Bordhöhe in M" required/>
					<x-form-input floating name="mast_length" type="number" step="1" min="0" label="Mastlänge in M"/>
					<x-form-input floating name="mast_weight" type="number" step="1" min="0" label="Mastgewicht in Kg"/>
					<x-form-input floating name="draft" type="number" step="0.1" min="0.1" label="Tiefgang in M" required/>
					<x-form-input floating name="length_waterline" type="number" step="0.1" min="0.1" label="Länge Wasserlinie in M" required/>
					<x-form-input floating name="length_keel" type="number" step="0.1" min="0" label="Kiellänge ih M"/>
				</div>
			</div>
			<div class="row mt-2 ms-2">
				<x-form-submit class="col-1 btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection

@push('inline-scripts')
<script>
	$(document).ready(() => {
		const frm = document.frm,
			options = {!! $customerOptions !!},
			bindings = {
				name: frm.name,
				email: frm.email,
				fon: frm.fon,
				state: frm.state,
			};
		MyForm.autocomplete(".autocomplete", "#autocomplete", options, 'name', bindings);
	})
</script>
@endpush
