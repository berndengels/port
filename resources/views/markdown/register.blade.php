@component('mail::message')
## Neue Kunden Registrierung erfogt
### Registrierungs Bestätigung für neuen Kunden
- Name: {{ $customer->name }}
- Email: <{{ $customer->email }}>
- Telefon: {{ $customer->fon }}
- Adresse: {{ $customer->street }}, {{ $customer->poszcode }} {{ $customer->city }}
### Boots Angaben
- Name: {{ $boat->boat_name }}
- Typ: {{ ucfirst($boat->boat_type) }}
- Länge: {{ $boat->length }} m
- Länge Wasserlinie: {{ $boat->length_waterline ?? 0 }} m
- Breite: {{ $boat->width }} m
- Gewicht: {{ $boat->weight }} Kg
- Tiefgang: {{ $boat->draft ?? 0 }} m
@if('sail' === $boat->boat_type)
- Länge Mast: {{ $boat->mast_length ?? 0 }} m
- Gewicht Mast: {{ $boat->mast_weight ?? 0 }} Kg
- Länge Kiel: {{ $boat->length_keel ?? 0 }} m
@endif

@component('mail::button', ['url' => route('admin.customers.edit', $customer)])
    Bitte hier Registrierung bestätigen
@endcomponent

Danke,<br>
{{ config('app.name') }}
@endcomponent
