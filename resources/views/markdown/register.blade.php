@component('mail::message')
	## Neue Kunden Registrierung erfolgt
	### Registrierungs Bestätigung für neuen Kunden
	- Art: {{ __($customer->type) }}
	- Name: {{ $customer->name }}
	- Email: <{{ $customer->email }}>
	@if($customer->fon)
		- Telefon: {{ $customer->fon }}
	@endif
	@if($customer->street && $customer->postcode && $customer->city)
		- Adresse: {{ $customer->street }}, {{ $customer->postcode }} {{ $customer->city }}
	@endif

	@component('mail::button', ['url' => route('admin.customers.edit', $customer)])
		Bitte hier Registrierung bestätigen
	@endcomponent

	Danke,<br>
	{{ config('app.name') }}
@endcomponent
