@component('mail::message')
	## Sehr gehrte(r) {{ $customer->name }}


	@switch($customer->type)
		@case('boat')
			Ihre Registrierung wurde erfolgreich bestätigt.
			Sie können jetzt über das Kunden-Login Ihre Daten
			verwalten oder Service-Anfragen zu erstellen.
			@break
		@case('renter')
			Ihre Registrierung wurde erfolgreich bestätigt.
			Sie können jetzt über das Kunden-Login Ihre Daten
			verwalten. Sie können dort auch Reservierungen für ein Mietobjekt vornehmen.
			@break
	@endswitch

	@component('mail::button', ['url' => $url])
		Zum Login
	@endcomponent

	Danke,<br>
	{{ config('app.name') }}
@endcomponent
