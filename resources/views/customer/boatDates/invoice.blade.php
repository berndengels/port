## {{ config('app.name') }}</h3>
### Rechnung für **{{ $modus }}** vom {{ $data->from->format('d.m.Y') }} bis {{ $data->until->format('d.m.Y') }}
### Boot: {{ $data->boat->name }}
@if($customer)
- Name: {{ $customer->name }}<br>
- Email: <{{ $customer->email }}><br>
- Telefon: {{ $customer->fon }}<br>
- Adresse: {{ $customer->street }}, {{ $customer->poszcode }} {{ $customer->city }}<br>
@endif

Preis für {{ $modus }} {{ $prices->priceBase }} €
@if($prices->priceCrane > 0)
- Kranen: {{ $prices->priceCrane }} €
@endif
@if($prices->priceMastCrane > 0)
- Mast-Kranen: {{ $prices->priceMastCrane }} €
@endif
@if($prices->priceCleaning > 0)
- Reinigung {{ $prices->priceCleaning }} €
@endif
<h3>Summe Preis: {{ $data->price }} €

Danke für Ihren Besuch

© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
