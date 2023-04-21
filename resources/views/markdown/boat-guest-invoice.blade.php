@php use Carbon\Carbon; @endphp
@component('mail::message')
# Rechnung für Liegeplatz vom {{ $data->from->format('d.m.Y') }} bis {{ $data->until->format('d.m.Y') }}
- Boot: {{ $data->boat->name }}
- Boots-Länge: {{ $data->boat->length }} m
- Anzahl Personen: {{ $data->persons }}
- Strom-Anschluss: {{ $data->electric ? 'Ja' : 'Nein' }}

@if($prices->days > 1)
- {{ $prices->days }} Übernachtungen
@else
- {{ $prices->days }} Übernachtung
@endif
- Grund-Preis: {{ $prices->priceBase }} €
@if($prices->priceElectric > 0)
- Preis Strom: {{ $prices->priceElectric }} € ({{ $prices->priceElectric/$prices->days }} € pro Tag)
@endif
@if($prices->pricePersons > 0)
- Preis Personen: {{ $prices->pricePersons }} € ({{ $prices->pricePersons/$prices->days }} € pro Tag)
@endif

### Tages-Preise
@foreach($prices->dailyPrices as $date => $d)
- {{ Carbon::make($date)->translatedFormat('D d.m.Y') }} ({{ $d->saison }}) {{ $d->price }} €
@endforeach

MWSt Rate: {{ $prices->tax }} %\
Anteil MWSt: {{ $prices->taxPrice }} €\
Summe Preis (Netto): {{ $prices->netto }} €\
Summe Preis (Brutto): {{ $prices->total }} €

Danke,<br>
{{ config('app.name') }}
@endcomponent
