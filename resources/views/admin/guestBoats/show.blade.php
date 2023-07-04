@php
/**
 * @var $guestBoat \App\Models\GuestBoat
 */
@endphp
@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.guestBoats.index') }}"/>
	</div>

	<div class="container mt-3 ms-0 ps-2 ps-lg-0">
		<div class="row gy-3 ps-0">
			<div class="col-11 col-lg-4">
				<div class="card">
					<div class="card-header"><strong>Boot {{ $guestBoat->name }}</strong></div>
					<div class="card-body p-3">
						@if($guestBoat->type)
							<div class="row">
								<div class="col-3">Typ</div>
								<div class="col-auto">{{ __($guestBoat->type) }}</div>
							</div>
						@endif
						<div class="row">
							<div class="col-3">Länge</div>
							<div class="col-auto">{{ $guestBoat->length }} m</div>
						</div>
						<div class="row">
							<div class="col-3">Email</div>
							<div class="col-auto"><a href="mailto:{{ $guestBoat->email }}"
													 target="_blank">
									<i class="fas fa-mail"></i>
									{{ $guestBoat->email }}
								</a></div>
						</div>
						@if($guestBoat->weight)
							<div class="row">
								<div class="col-3">Gewicht</div>
								<div class="col-auto">{{ $guestBoat->weight }} Kg</div>
							</div>
						@endif
						@if($guestBoat->draft)
							<div class="row">
								<div class="col-3">Tiefgang</div>
								<div class="col-auto">{{ $guestBoat->draft }} m</div>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>


	</div>
@endsection

