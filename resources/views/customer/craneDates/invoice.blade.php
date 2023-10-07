## {{ config('app.name') }}
### Rechnung für **{{ $modus }}** vom {{ $data->from->format('d.m.Y') }} bis {{ $data->until->format('d.m.Y') }}
### Boot: {{ $data->boat->name }}

- Name: {{ $customer->name }}<br>
- Adresse: {{ $customer->street }}, {{ $customer->postcode }} {{ $customer->city }}<br>

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
@if($prices->priceTransport > 0)
	- Boot-Transport: {{ $prices->priceTransport }} €
@endif

MWSt Rate: {{ $prices->tax }} %\
Anteil MWSt: {{ $prices->taxPrice }} €\
Summe Preis (Netto): {{ $prices->netto }} €\
Summe Preis (Brutto): {{ $prices->total }} €

Bitte überweisen Sie den ausgewiesenen Betrag auf folgendes Konto

Konto-Inhaber:&nbsp;&nbsp;&nbsp;{{ $settings->name }}<br>
Bank-Institut:&nbsp;&nbsp;&nbsp;{{ $settings->bank }}<br>
IBAN:&nbsp;&nbsp;&nbsp;&nbsp;{{ $settings->iban }}<br>
BIC:&nbsp;&nbsp;&nbsp;&nbsp;{{ $settings->bic }}<br>

Danke für Ihren Besuch
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
