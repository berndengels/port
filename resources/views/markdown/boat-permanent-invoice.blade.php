@component('mail::message')
	@slot('header')
		@component('mail::header', ['url' => config('app.url')])
			{{ config('app.name') }}
		@endcomponent
	@endslot

	### Rechnung für **{{ $modus }}** vom {{ $data->from->format('d.m.Y') }} bis {{ $data->until->format('d.m.Y') }}
	- Name: {{ $customer->name }}
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

	@slot('footer')
		Danke für Ihren Besuch,
		{{ config('app.name') }}
		@component('mail::footer')
			© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
		@endcomponent
	@endslot

@endcomponent
