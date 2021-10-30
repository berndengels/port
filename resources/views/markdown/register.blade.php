@component('mail::message')
# Registrierungs Bestätigung für neuen Kunden
- Name: {{ $customer->name }}
- Email: <{{ $customer->email }}>
- Telefon: {{ $customer->fon }}
- Adresse: {{ $customer->street }}, {{ $customer->poszcode }} {{ $customer->city }}

@component('mail::button', ['url' => route('admin.customers.edit', $customer)])
    Bitte hier Registrierung bestätigen
@endcomponent

Danke,<br>
{{ config('app.name') }}
@endcomponent
