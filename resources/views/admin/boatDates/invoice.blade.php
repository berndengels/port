### {{ config('app.name') }}
### Rechnung für **{{ $modus }}** vom {{ $data->from->format('d.m.Y') }} bis {{ $data->until->format('d.m.Y') }}
- Name: {{ $customer->name }}
- Email: <{{ $customer->email }}>
- Telefon: <tel:{{ $customer->fonLink }}>
- Adresse: {{ $customer->street }}, {{ $customer->postcode }} {{ $customer->city }}

### Preisdetails

{{ $modus }}: {{ $prices->price }} €

@if($data->isCraned)
Kranen: {{ $prices->crane }} €
@endif

@if($data->isMastCraned)
Mast-Kranen: {{ $prices->mast_crane }} €
@endif

@if($data->isCleaned)
Reinigung {{ $prices->cleaning }} €
@endif

### Summe Preis: {{ $data->price }} €

Danke,<br>
{{ config('app.name') }}


