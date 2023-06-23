@extends('layouts.main')

@section('main')
	<div class="align-content-center">
		<div class="clearfix">
			<div class="float-start">
				<x-btn-back route="{{ route('customer.boatDates.index') }}"/>
			</div>
			<div class="float-end">
				<x-btn-print route="{{ route('customer.boatDates.print', $boatDate) }}"/>
			</div>
		</div>
		<div class="container mt-3 ms-0 ps-2 ps-lg-0">
			<div class="row gy-3 ps-0">
				<div class="col-11 col-lg-4">
					<div class="card">
						<div class="card-header">
							<trong>Boot {{ $boatDate->boat->name }}</trong>
						</div>
						<div class="card-body p-3">
							<div class="row">
								<div class="col-2">Type</div>
								<div class="col-auto">{{ __($boatDate->boat->type) }}</div>
							</div>
							<div class="row">
								<div class="col-2">Länge</div>
								<div class="col-auto">{{ $boatDate->boat->length }} m</div>
							</div>
							<div class="row">
								<div class="col-2">Breite</div>
								<div class="col-auto">{{ $boatDate->boat->width }} m</div>
							</div>
							<div class="row">
								<div class="col-2">Gewicht</div>
								<div class="col-auto">{{ $boatDate->boat->weight/1000 }} T</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-11 col-lg-2">
					<div class="card">
						<div class="card-header"><strong>Saison {{ __($boatDate->modus) }}</strong></div>
						<div class="card-body p-3">
							<div class="row">
								<div class="col-3">Von</div>
								<div class="col-auto">{{ $boatDate->from->format('d.m.Y') }}</div>
							</div>
							<div class="row">
								<div class="col-3">Bis</div>
								<div class="col-auto">{{ $boatDate->until->format('d.m.Y') }}</div>
							</div>
							<div class="row">
								<div class="col-3">Tage</div>
								<div class="col-auto">{{ $boatDate->days }}</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-11 col-lg-4">
					<x-show-guest-prices :prices="$priceData"/>
				</div>
			</div>
		</div>
	</div>
@endsection

