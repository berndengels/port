@component('mail::layout')
@slot('header')
@component('mail::header', ['url' => config('app.url')])
<img class="logo" src="data:image/png;base64,{{ $logo }}" width="80" height="80"> {{ config('app.name') }}
@endcomponent
@endslot

# Excel-Tabelle Caravan-Rezeption
@if($data->from)
- Von: {{ $data->from }}
@endif
@if($data->until)
- Bis: {{ $data->until }}
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
