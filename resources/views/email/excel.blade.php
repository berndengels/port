@component('mail::layout')
@slot('header')
@component('mail::header', ['url' => config('app.url')])
@endcomponent
@endslot

# Excel-Tabelle Caravan-Rezeption
@if($data->from)
- Daten ab: {{ $data->from->format('d.m.Y') }}
@endif
@if($data->until)
- Daten bis: {{ $data->until->format('d.m.Y') }}
@endif
- Anzahl {{ $data->count }}
- Summe Total: {{ $data->priceTotal }} €

Datei steht im Anhang zu Download bereit.

@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot

@endcomponent
