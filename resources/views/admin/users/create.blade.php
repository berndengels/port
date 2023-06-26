@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.users.index') }}"/>
		<x-form method="post" :action="route('admin.users.store')" class="w-half mt-3">
			<x-form-input name="name" label="Name" required/>
			<x-form-input type="email" name="email" label="Email" required/>
			<x-form-input name="fon" label="Mobiltelefon"/>
			<x-form-input type="password" name="password" label="Passwort" required/>
			<x-form-input type="password" name="password_repeat" label="Passwort wiederholen" required/>
			@can('write Role')
				<x-form-select name="roles[]" label="Role" :options="$roles" multiple/>
			@endcan
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection

