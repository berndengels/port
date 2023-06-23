@php use Carbon\Carbon; @endphp
@extends('layouts.print')

@section('main')
	<div class="container justify-content-center ms-5 mt-0 p-0 w-100">
		<div class="w-100">
			<x-invoice-header/>
			<br>
			<h5>Rechnung für Stellplatz vom {{ $caravanDate->from->format('d.m.Y') }}
				bis {{ $caravanDate->until->format('d.m.Y') }}</h5>
			<div class="row mt-3">
				<div class="col-3">Datum</div>
				<div class="col">{{ Carbon::today()->format('d.m.Y') }}</div>
			</div>
			<div class="row">
				<div class="col-3">Kennzeichen</div>
				<div class="col">
					<span class="carnumber">{{ $caravanDate->caravan->carnumber }}</span>
				</div>
			</div>
			<div class="row">
				<div class="col-3">Länge</div>
				<div class="col">{{ $caravanDate->caravan->carlength }} m</div>
			</div>
			<div class="row">
				<div class="col-3">Anzahl Tage</div>
				<div class="col">{{ $caravanDate->days }}</div>
			</div>
			<div class="row">
				<div class="col-3">Anzahl Personen</div>
				<div class="col">{{ $caravanDate->persons }}</div>
			</div>
			<div class="row">
				<div class="col-3">Stromanschluss</div>
				<div class="col">{{ $caravanDate->electric ? 'Ja' : 'Nein' }}</div>
			</div>

			<x-invoice-guest-prices :prices="$priceData"/>
			<br>
			<x-invoice-footer/>
		</div>
	</div>
@endsection
