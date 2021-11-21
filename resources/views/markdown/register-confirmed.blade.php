@component('mail::message')
## Sehr gehrte(r) {{ $customer->name }}

Ihre Registrierung wurde erfolgreich bestätigt.
Sie können jetzt über das Kunden-Login Ihre Daten
verwalten oder Service-Anfragen zu erstellen.

@component('mail::button', ['url' => $url])
    Zum Login
@endcomponent

Danke,<br>
{{ config('app.name') }}
@endcomponent
