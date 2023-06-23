@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.houses.index') }}"/>
		<x-form name="frm" method="post" :action="route('admin.houses.store')" class="w-half mt-3">
			<x-form-input name="name" label="Name" placeholder="Haus Name" required/>
			<x-form-select name="house_model_id" label="Modell" :options="$models" required/>
			<x-form-input name="calendar_color" type="color" label="Calender Farbe" placeholder="Calender Farbe"/>
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection
