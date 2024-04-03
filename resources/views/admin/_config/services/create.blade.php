@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.configServices.index') }}"/>
		<x-form name="frm" method="post" :action="route('admin.configServices.store')" class="w-half mt-3">
			<x-form-input name="name" label="Name" placeholder="Service Name" required/>
			<x-form-input name="key" label="Key" class="mb-0 pb-0" placeholder="Key Name" required/>
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection
