@php
/**
* @var $boat \App\Models\Boat
* @var $media \App\Models\Media
 */
$images = $boat->getMedia('boat');
$delay = 15000;
@endphp
@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.boats.index') }}"/>
	</div>

	<div class="container mt-3 ms-0 ps-2 ps-lg-0">
		<!--div class="row gy-3 ps-0">
			<div class="col-11 col-lg-4">
				<div class="card">
					<div class="card-header"><strong>Boot {{ $boat->name }}</strong></div>
					<div class="card-body p-3">
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
		</div-->

		<div class="row">
		@foreach($images as $index => $media)
			<div class="col-sm-12 col-lg-auto p-2 bg-dark me-3 mt-sm-3 mt-lg-0 rounded-3 shadow">
				<img data-large="{{ asset($media->getUrl('large')) }}" src="{{ asset($media->getUrl('thumb')) }}" alt="{{ $media->name }}" title="{{ $media->name }}" class="enlargable rounded-3 w-100" />
			</div>
		@endforeach
		</div>

	</div>
@endsection

@push('inline-scripts')
<script>
$(document).ready(() => {
	$('.enlargable').click(e => Fullscreen.init(e.target.dataset.large));
});
</script>
@endpush
