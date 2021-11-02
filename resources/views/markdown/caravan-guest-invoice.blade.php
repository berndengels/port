@component('mail::message')
# {{ config('app.name') }}
- Caravan: {{ $data->caravan->carnumber }}

# Rechnung für Stellplatz vom {{ $data->from->format('d.m.Y') }} bis {{ $data->until->format('d.m.Y') }}

@if($prices->daysCount > 1)
    - {{ $prices->daysCount }} Übernachtungen
@else
    - {{ $prices->daysCount }} Übernachtung
@endif

@if($prices->priceIndividual > 0)
- Sonderpreis: {{ $prices->priceIndividual }} €
@else
- Basis-Preis: {{ $prices->priceBase }} €
- Personen-Preis:  {{ $prices->pricePersons }} €
- Preis Stromanschluß: {{ $prices->priceElectric }} €
@endif

Summe Preis: {{ $prices->total }} €

Danke,<br>
{{ config('app.name') }}
@endcomponent
