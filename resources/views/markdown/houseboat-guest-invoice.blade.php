@markdown
### <a href="{{ config('app.url') }}" target="_blank">{{ config('app.name') }}</a>

### Rechnung für Vermietung von Hausboot **{{ $houseboatDate->houseboat->name }}** vom {{ $houseboatDate->from->format('d.m.Y') }} bis {{ $houseboatDate->until->format('d.m.Y') }}
- Name: {{ $houseboatDate->customer->name }}
- Email: <{{ $houseboatDate->customer->email }}>
- Telefon: {{ $houseboatDate->customer->fon }}
- Adresse: {{ $houseboatDate->customer->street }}, {{ $houseboatDate->customer->poszcode }} {{ $houseboatDate->customer->city }}

@if($days > 1)
    - {{ $days }} Übernachtungen
@else
    - {{ $days }} Übernachtung
@endif

### Tages Preise
| Datum      | Saison | Feiertag | Preis |
| ----------- | ----------- | ----------- | ----------- |

@foreach($dailyPrices as $item)
| {{ $item->date }} | {{ __($item->saison) }} | {{ $item->holiday ?? '' }} | {{ $item->price }} € |
@endforeach

@if(config('port.prices.tax.enabled'))
Netto-Preis:
MWSt: {{ config('port.prices.tax.rate') }} %
@endif
Basis Preis: {{ $basePrice }} €
Summe Preis: {{ $priceTotal }} €

Danke für Ihren Besuch,
{{ config('app.name') }}
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endmarkdown
