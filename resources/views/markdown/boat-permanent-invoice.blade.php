@component('mail::layout')
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

### Rechnung für **{{ $modus }}** vom {{ $data->from->format('d.m.Y') }} bis {{ $data->until->format('d.m.Y') }}
- Name: {{ $customer->name }}
- Email: <{{ $customer->email }}>
- Telefon: {{ $customer->fon }}
- Adresse: {{ $customer->street }}, {{ $customer->poszcode }} {{ $customer->city }}

Grund-Preis für {{ $modus }} {{ $prices->priceBase }} €

@if($prices->priceCrane > 0)
- Kranen: {{ $prices->priceCrane }} €
@endif

@if($prices->priceMastCrane > 0)
- Mast-Kranen: {{ $prices->priceMastCrane }} €
@endif

@if($prices->priceCleaning > 0)
- Reinigung {{ $prices->priceCleaning }} €
@endif

Summe Preis: {{ $data->price }} €

@slot('footer')
Danke für Ihren Besuch,
{{ config('app.name') }}
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot

@endcomponent
