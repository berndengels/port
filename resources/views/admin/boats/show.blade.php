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

		<!--div class="row"-->
			<!--div id="carousel"
				 class="carousel carousel-fade"
				 data-bs-ride="carousel"
			>
				<div class="carousel-indicators">
					@foreach($images as $index => $media)
						<button type="button" data-bs-target="#carousel" data-bs-slide-to="{{ $index }}" aria-label="{{ $media->name }}"></button>
					@endforeach
				</div>
				<div class="carousel-inner">
					@foreach($images as $index => $media)
						<div class="carousel-item @if($loop->first) @endif" data-bs-interval="{{ $delay }}">
							<div class="">
								<div class="carousel-caption">
									<h5>{{ $media->name }}</h5>
									<p>
										<img src="{{ $media->getUrl('large')}}" alt="{{ $media->name }}" title="{{ $media->name }}" height="800" />
									</p>
								</div>
							</div>
						</div>
					@endforeach
				</div>
				<div class="carousel-control">
					<button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Zurück</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Nächste</span>
					</button>
				</div>
			</div>
		</div-->
		@foreach($images as $index => $media)
			<div class="row">
				<div class="col-12">
					<h5>{{ $media->name }}</h5>
					<img data-enlargable src="{{ $media->getUrl('large')}}" alt="{{ $media->name }}" title="{{ $media->name }}" style="width:100%" />
				</div>
			</div>
		@endforeach

	</div>
@endsection

@push('inline-scripts')
<script>
$(document).ready(() => {
	$('img[data-enlargable]').click(e => {
		let src = $(e.target).attr('src');
		$('<div>')
			.attr('class', 'fullscreen')
			.css({backgroundImage: 'url(' + src + ')'})
			.click(e => {
				$(e.target)
					.removeClass('fullscreen')
					.remove();
			})
			.appendTo('body');
	});
});
</script>
@endpush
