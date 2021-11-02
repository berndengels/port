@component('mail::message')
# {{ config('app.name') }}
- Boot: {{ $data->boat->name }}

# Rechnung für Liegeplatz vom {{ $data->from->format('d.m.Y') }} bis {{ $data->until->format('d.m.Y') }}

@if($prices->daysCount > 1)
- {{ $prices->daysCount }} Übernachtungen
@else
- {{ $prices->daysCount }} Übernachtung
@endif

Summe Preis: {{ $data->price }} €

Danke,<br>
{{ config('app.name') }}
@endcomponent
