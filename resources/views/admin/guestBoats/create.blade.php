@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.guestBoats.index') }}"/>
		<x-form name="frm" method="post" :action="route('admin.guestBoats.store')" class="w-half mt-3">
			<x-form-input floating name="name" label="Name" required/>
			<x-form-select floating name="type" label="Typ" :options="$types" />
			<x-form-input floating name="length" label="Länge"  required/>
			<x-form-input floating name="weight" type="number" min="1" label="Boots Gewicht in Kg" />
			<x-form-input floating name="draft" type="number" step="0.1" min="0.1" label="Tiefgang in M" />
			<x-form-input floating name="home_port" label="Heimathafen" />
			<x-form-input floating name="email" type="email" label="Email"/>
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection
