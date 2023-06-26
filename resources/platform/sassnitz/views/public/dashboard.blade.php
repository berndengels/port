@php $delay = 15000; @endphp
@extends('layouts.main')
@push('bodyCss', 'overflow-hidden')

@section('main-full')
	<div class="bg-main dashboard">
		<div id="carousel"
			 class="carousel carousel-fade"
			 data-bs-ride="carousel"
		>
			<div class="carousel-indicators">
				<button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active" aria-current="true"
						aria-label="Boote"></button>
				<button type="button" data-bs-target="#carousel" data-bs-slide-to="1" aria-label="Caravans"></button>
				<button type="button" data-bs-target="#carousel" data-bs-slide-to="2" aria-label="Hausboote"></button>
				<button type="button" data-bs-target="#carousel" data-bs-slide-to="3"
						aria-label="Dienstleistungen"></button>
			</div>
			<div class="carousel-inner">
				<div class="carousel-item active" data-bs-interval="{{ $delay }}">
					<div class="boat">
						<div class="carousel-caption">
							<h3>Sassnitz Boote</h3>
							<p>
								Verwaltung von Gastbooten und Dauerliegern. Tagespreis Konfiguration für Gäste.
								Sommer- und Winterlager Preis-Konfiguration. Automatische Erstellung von Rechnungen
								inkl. einer
								internen Buchhaltung. Exporte von Einnahmen in Excel und PDF-Dateien.
							</p>
						</div>
					</div>
				</div>
				<div class="carousel-item" data-bs-interval="{{ $delay }}">
					<div class="caravan">
						<div class="carousel-caption">
							<h3>Caravans</h3>
							<p>
								Verfügen Sie über Caravan-Stellplätze, so können Sie hier Ihre Besucher verwalten.
								Konfigurieren Sie die Tagespreis je nach Haupt- und Nebensaison.
								Tagespreis Optionen wie Anzahl der Gäste, Stromanschluss können Sie selbst festlegen
								und So einfach und schnell Preise berechnen.
								Exporte von Einnahmen in Excel und PDF-Dateien.
							</p>
						</div>
					</div>
				</div>
				<div class="carousel-item" data-bs-interval="{{ $delay }}">
					<div class="houseboat">
						<div class="carousel-caption">
							<h3>Häuser, Hausboote, Apartments</h3>
							<p>
								Verfügen Sie auch über Häuser, Hausboote oder Apartments, die Sie an Ihre Gäste
								vermieten wollen. Hier können Sie die Tagespreise je nach Saison (Haupt, Zwischen,
								Neben-Saison)
								konfigurieren. Die Belegungen können Sie leicht über ein Kalendersystem definieren.
								Rechnungserstellung natürlich inklusive.
								Exporte von Einnahmen in Excel und PDF-Dateien.
							</p>
						</div>
					</div>
				</div>
				<div class="carousel-item" data-bs-interval="{{ $delay }}">
					<div class="service">
						<div class="carousel-caption">
							<h3>Services</h3>
							<p>
								Wollen Sie Ihren Boots-Dauerliegern oder anderen registrierten Bootsbesuchern
								typische Service-Leistungen wie Schleifarbeiten, Polieren, Antifouling-Anstrich oder
								anderes
								anbieten. Hier können Sie diese zwecks Abrechnung konfigurieren.
								Rechnungserstellung natürlich inklusive.
								Exporte von Einnahmen in Excel und PDF-Dateien.
							</p>
						</div>
					</div>
				</div>
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
		<!--div class="flex-item-dashboard p-3 widget">
			<div class="title weatherTitle">Wetter</div>
			<div class="content mt-2 weather"></div>
		</div>
		<x-open-sea-map /-->
		{{--
		@if($widgets->count() > 0)
			@foreach($widgets as $item)
			<x-widget
					title="{{ $item->title }}"
					content="{{ $item->content }}"
			/>
			@endforeach
		@endif
		--}}
	</div>
@endsection
@push('inline-scripts')
	<script>
		/*
				var myCarousel = document.querySelector('#carouselDashboard')
				var carousel = new bootstrap.Carousel(myCarousel, {
					interval: 3000,
					wrap: false
				})
		*/
		//	    Weather.get('.flex-container-dashboard .widget .weather');
	</script>
@endpush
