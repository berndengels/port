@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.customers.' . (isset($route) ? $route : 'index')) }}"/>
		<x-form method="post" :action="route('admin.customers.store')" class="w-half mt-3">
			@can('confirm Registration')
				<x-form-checkbox name="confirmed" label="Bestätigt" class="mb-0 pb-0"/>
			@endcan
			@can('write Role')
				<x-form-select name="roles[]" label="Role" :options="$roles" :default="$role" multiple/>
			@endcan
			<x-form-select name="type" label="Typ" :options="$customerTypes" :default="$type" required/>
			<x-form-input name="name" label="Name" required/>
			<x-form-input type="email" name="email" label="Email"/>
			<x-form-input type="password" name="password" label="Passwort"/>
			<x-form-input type="password" name="password_confirmation" label="Passwort wiederholen"/>
			<x-form-input name="fon" type="tel" label="Telefon"/>
			<x-form-input name="city" label="Ort"/>
			<x-form-input name="postcode" label="PLZ"/>
			<x-form-input name="street" label="Strasse u. Hausnummer"/>
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection

