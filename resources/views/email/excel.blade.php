@component('mail::layout')
	@slot('header')
		@component('mail::header', ['url' => config('app.url')])
		@endcomponent
	@endslot

# Excel-Tabelle Rezeption
@if($data->from)
- Von: {{ $data->from->format('d.m.Y') }}
@endif
@if($data->until)
- Bis: {{ $data->until->format('d.m.Y') }}
@endif
- Anzahl {{ $data->count }} Datensätze
- Summe Total: {{ $data->brutto }} €
- Netto: {{ Str::replace('.',',',$data->netto) }} €
- Anteil MWSt: {{ Str::replace('.',',',$data->mwst) }} €
@if($data->settings->use_tax)
- MWSt: {{ $data->settings->tax }} %
@endif

Datei steht im Anhang zum Download bereit.

@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot

@endcomponent
