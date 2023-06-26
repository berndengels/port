@php use Carbon\Carbon; @endphp
@extends('layouts.print')

@section('main')
	<div class="container">
		<div class="w-100">
			<x-invoice-header/>
			<br>
			<h5>Rechnung für
				Gastliegeplatz {{ $guestBoatDate->berth->dock->name }}{{ $guestBoatDate->berth->number }}</h5>
			<div class="row mt-3">
				<div class="col-3">Datum</div>
				<div class="col">{{ Carbon::today()->format('d.m.Y') }}</div>
			</div>
			<div class="row">
				<div class="col-3">Boot</div>
				<div class="col">{{ $guestBoatDate->boat->name }}</div>
			</div>
			<div class="row">
				<div class="col-3">Länge</div>
				<div class="col">{{ $guestBoatDate->boat->length }} m</div>
			</div>
			<div class="row">
				<div class="col-3">Von</div>
				<div class="col">{{ $guestBoatDate->from->format('d.m.Y') }}</div>
			</div>
			<div class="row">
				<div class="col-3">Bis</div>
				<div class="col">{{ $guestBoatDate->until->format('d.m.Y') }}</div>
			</div>
			<div class="row">
				<div class="col-3">Anzahl Tage</div>
				<div class="col">{{ $guestBoatDate->days }}</div>
			</div>
			<div class="row">
				<div class="col-3">Anzahl Personen</div>
				<div class="col">{{ $guestBoatDate->persons }}</div>
			</div>
			<div class="row">
				<div class="col-3">Stromanschluss</div>
				<div class="col">{{ $guestBoatDate->electric ? 'Ja' : 'Nein' }}</div>
			</div>

			<x-invoice-guest-prices :prices="$priceData"/>
			<br>
			<x-invoice-footer/>
		</div>
	</div>
@endsection
