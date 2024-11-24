@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.apartments.index') }}"/>
		<x-form name="frm" method="post" :action="route('admin.apartments.update', $apartment)" class="w-half mt-3">
			@method('put')
			@bind($apartment)
			<x-form-input name="name" label="Name" placeholder="Apartment Name" required/>
			<x-form-select name="apartment_model_id" label="Modell" :options="$models" required/>
			<x-form-input name="calendar_color" type="color" label="Calender Farbe"/>
			@endbind
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection
