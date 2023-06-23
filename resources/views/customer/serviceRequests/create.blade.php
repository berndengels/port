@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back :route="route('customer.serviceRequests.index')"/>
		<x-form method="post" :action="route('customer.serviceRequests.store')" class="w-half mt-3">
			<x-form-select name="boat_id" label="Boot" :options="$boats" required/>
			<x-form-select name="services[]" label="Services" :options="$services" class="flexy" size="10" many-relation
						   multiple/>
			<x-form-input name="description" label="Kurze Beschreibung" required/>
			<x-form-input type="date" name="done_until" label="gewünschte Ausführung bis" required/>
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection

