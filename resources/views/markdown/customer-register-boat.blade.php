@component('mail::message')
## Neue Kunden Registrierung erfolgt
### Hier Ihre Kunden-Daten
- Art: {{ __($customer->type) }}
- Name: {{ $customer->name }}
- Email: <{{ $customer->email }}>
- Telefon: {{ $customer->fon }}
- Adresse: {{ $customer->street }}, {{ $customer->postcode }} {{ $customer->city }}

Sobald Ihre Registrierung bestätigt wurde, erhalten Sie eine weitere Email.
Wenn Sie sich über das Kunden-Login einloggen, sehen Sie weitere Inhalte, um Ihre Daten zu
verwalten oder Service-Anfragen zu erstellen.

Danke für Ihre Anmeldung,<br>
{{ config('app.name') }}
@endcomponent
