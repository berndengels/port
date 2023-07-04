@php
/**
* @var $boat \App\Models\Boat
* @var $media \App\Models\Media
 */
$images = $boat->getMedia('boat');
@endphp
@extends('layouts.main')

@slot('styles')
	<link rel="stylesheet" href="{{ mix('jquery-mobile/jquery.mobile-1.4.5.min.css') }}">
@endslot
@slot('scripts')
	<link rel="stylesheet" href="{{ mix('jquery-mobile/jquery.mobile-1.4.5.min.js') }}">
@endslot

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.boats.index') }}"/>
	</div>

	<div class="container mt-3 ms-0 ps-2 ps-lg-0">
		<div class="row gy-3 ps-0">
			<div class="col-11 col-lg-4">
				<div class="card">
					<div class="card-header"><strong>Boot {{ $boat->name }}</strong></div>
					<div class="card-body p-3">
						@if($boat->berth)
							<div class="row">
								<div class="col-3">Liegeplatz</div>
								<div class="col-auto">{{ $boat->berth->dock->name }} {{ $boat->berth->number }}</div>
							</div>
						@endif
						<div class="row">
							<div class="col-3">Typ</div>
							<div class="col-auto">{{ __($boat->type) }}</div>
						</div>
						<div class="row">
							<div class="col-3">Eigner</div>
							<div class="col-auto">{{ $boat->customer->name }}</div>
						</div>
						<div class="row">
							<div class="col-3">Email</div>
							<div class="col-auto"><a href="mailto:{{ $boat->customer->email }}"
													 target="_blank">
									<i class="fas fa-mail"></i>
									{{ $boat->customer->email }}
								</a></div>
						</div>
						<div class="row">
							<div class="col-3">Fon</div>
							<div class="col-auto">
								@if($boat->customer->fon)
									<a href="tel:{{ $boat->customer->fonLink }}" target="_blank">
										<i class="fas fa-phone"></i>
										{{ $boat->customer->fon }}
									</a>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-11 col-lg-4">
				<div class="card">
					<div class="card-header"><strong>Maße</strong></div>
					<div class="card-body p-3">
						<div class="row">
							<div class="col-6">Länge</div>
							<div class="col-auto">{{ $boat->length }} m</div>
						</div>
						<div class="row">
							<div class="col-6">Breite</div>
							<div class="col-auto">{{ $boat->width }} m</div>
						</div>
						<div class="row">
							<div class="col-6">Gewicht</div>
							<div class="col-auto">{{ $boat->weight }} Kg</div>
						</div>
						<div class="row">
							<div class="col-6">Tiefgang</div>
							<div class="col-auto">{{ $boat->draft }} m</div>
						</div>
						<div class="row">
							<div class="col-6">Bordhöhe</div>
							<div class="col-auto">{{ $boat->board_height }} m</div>
						</div>

						@if('sail' === $boat->type)
							<div class="row">
								<div class="col-6">Mastlänge</div>
								<div class="col-auto">{{ $boat->mast_length }} m</div>
							</div>
							<div class="row">
								<div class="col-6">Mastgewicht</div>
								<div class="col-auto">{{ $boat->mast_weight }} Kg</div>
							</div>
							<div class="row">
								<div class="col-6">Länge Wasserlinie</div>
								<div class="col-auto">{{ $boat->length_waterline }} m</div>
							</div>
							<div class="row">
								<div class="col-6">Kiellänge</div>
								<div class="col-auto">{{ $boat->length_keel }} m</div>
							</div>
						@endif

					</div>
				</div>
			</div>
		</div>

		<div class="row mt-4 ms-1">
		@foreach($images as $index => $media)
			<div class="col-sm-12 col-lg-auto p-2 bg-dark me-3 mt-sm-3 mt-lg-0 rounded-3 shadow">
				@isMobile()
					<img src="{{ asset($media->getUrl('mobile')) }}" height="150" alt="{{ $media->name }}" title="{{ $media->name }}" class="rounded-3" />
				@else
					<img data-large="{{ asset($media->getUrl('large')) }}" src="{{ asset($media->getUrl('thumb')) }}" alt="{{ $media->name }}" title="{{ $media->name }}" class="enlargable rounded-3 w-100" />
				@endisMobile
			</div>
		@endforeach
		</div>

	</div>
@endsection

@push('inline-scripts')
<script>
$(document).ready(() => {
	@if($isNotMobile)
		$('.enlargable').click(e => Fullscreen.init(e.target.dataset.large));
	@endif
});
</script>
@endpush
