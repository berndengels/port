@component('mail::message')
	## Neue Kunden Registrierung erfolgt
	### Hier Ihre Kunden-Daten
	- Art: {{ __($customer->type) }}
	- Name: {{ $customer->name }}
	- Email: <{{ $customer->email }}>
	@if($customer->fon)
		- Telefon: {{ $customer->fon }}
	@endif
	@if($customer->street && $customer->postcode && $customer->city)
		- Adresse: {{ $customer->street }}, {{ $customer->postcode }} {{ $customer->city }}
	@endif

	@switch($customer->type)
		@case('permanent')
		@case('boat')
			Sobald Ihre Registrierung bestätigt wurde, erhalten Sie eine weitere Email.
			Wenn Sie sich über das Kunden-Login einloggen, sehen Sie weitere Inhalte, um Ihre Daten zu
			verwalten oder Service-Anfragen zu erstellen.
			@break
		@case('renter')
			Sobald Ihre Registrierung bestätigt wurde, erhalten Sie eine weitere Email.
			Wenn Sie sich über das Kunden-Login einloggen, sehen Sie weitere Inhalte, um Ihre Daten zu
			verwalten. Sie können dort auch Reservierungen für ein Mietobjekt vornehmen.
			@break
	@endswitch

	Danke für Ihre Anmeldung,<br>
	{{ config('app.name') }}
@endcomponent
