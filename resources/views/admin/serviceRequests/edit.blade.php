@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.serviceRequests.index') }}"/>
		<x-form method="post" :action="route('admin.serviceRequests.update', $serviceRequest)"
				class="mx-sm-2 mx-md-0 mt-2">
			@method('put')
			@bind($serviceRequest)
			<x-form-select name="boat_id" label="Kunde" :options="$boats" required/>
			<x-form-select name="services[]" label="Services" :options="$services" class="flexy" size="10" many-relation
						   multiple/>
			<x-form-input name="description" label="Beschreibung" required/>
			<x-form-checkbox name="done" label="Erledigt"/>
			<x-form-checkbox name="is_paid" label="Bezahlt"/>
			@endbind
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection

