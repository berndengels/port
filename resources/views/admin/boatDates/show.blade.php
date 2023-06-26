@extends('layouts.main')

@section('main')
	<div class="align-content-center">
		<div class="clearfix">
			<div class="float-start">
				<x-btn-back route="{{ route('admin.boatDates.index') }}"/>
			</div>
			<div class="float-end">
				<x-btn-print route="{{ route('admin.boatDates.print', $boatDate) }}"/>
				@if($boatDate->boat->customer->email)
					<x-btn-invoice :route="route('admin.boatDates.sendInvoice', $boatDate)"/>
				@endif
			</div>
		</div>
		<div class="container mt-3 ms-0 ps-2 ps-lg-0">
			<div class="row gy-3 ps-0">
				<div class="col-11 col-lg-4">
					<div class="card">
						<div class="card-header"><strong>Boot {{ $boatDate->boat->name }}</strong></div>
						<div class="card-body p-3">
							<div class="row">
								<div class="col-3">Eigner</div>
								<div class="col-auto">{{ $boatDate->boat->customer->name }}</div>
							</div>
							<div class="row">
								<div class="col-3">Email</div>
								<div class="col-auto"><a href="mailto:{{ $boatDate->boat->customer->email }}"
														 target="_blank">
										<i class="fas fa-mail"></i>
										{{ $boatDate->boat->customer->email }}
									</a></div>
							</div>
							<div class="row">
								<div class="col-3">Fon</div>
								<div class="col-auto">
									@if($boatDate->boat->customer->fon)
										<a href="tel:{{ $boatDate->boat->customer->fonLink }}" target="_blank">
											<i class="fas fa-phone"></i>
											{{ $boatDate->boat->customer->fon }}
										</a>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-11 col-lg-2">
					<div class="card">
						<div class="card-header">
							<strong>Saison {{ config('port.main.boat.dates.modi')[$boatDate->modus] }}</strong></div>
						<div class="card-body p-3">
							<div class="row">
								<div class="col-2">Von</div>
								<div class="col-auto">{{ $boatDate->from->format('d.m.Y') }}</div>
							</div>
							<div class="row">
								<div class="col-2">Bis</div>
								<div class="col-auto">{{ $boatDate->until->format('d.m.Y') }}</div>
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

