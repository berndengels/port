@component('mail::layout')
@slot('header')
@component('mail::header', ['url' => config('app.url')])
@endcomponent
@endslot

# Excel-Tabelle Caravan-Rezeption
@if($data->year)
- Jahr: {{ $data->year }}
@endif
@if($data->month)
- Monat: {{ $data->month }}
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
