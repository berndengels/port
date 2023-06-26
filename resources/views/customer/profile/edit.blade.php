@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back :route="route('customer.profile.show', $profile)"/>
		<x-form class="w-half mt-3" :action="route('customer.profile.update', $profile)">
			@method('put')
			@bind($profile)
			<x-form-input name="name" label="Name" required/>
			<x-form-input type="email" name="email" label="Email" required/>
			<x-form-input type="password" name="password" label="Passwort" :bind="false" autocomplete="off" readonly
						  onfocus="this.removeAttribute('readonly');"/>
			<x-form-input type="password" name="password_confirmation" label="Passwort wiederholen" autocomplete="off"/>

			<x-form-input name="fon" type="tel" label="Telefon"/>
			<x-form-input name="city" label="Ort"/>
			<x-form-input name="postcode" label="PLZ"/>
			<x-form-input name="street" label="Strasse u. Hausnummer"/>
			@endbind
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection

