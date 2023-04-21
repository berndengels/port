@php use Carbon\Carbon; @endphp
@extends('layouts.print')

@section('main')
    <div class="container justify-content-center">
        <div class="w-100">
            <x-invoice-header class="mb-5" />
            <br>
            <br>
            <x-recipient-header class="mt-5" :recipient="$serviceRequest->boat->customer" />

            <h5 class="w-100">Rechnung für: {{ $serviceRequest->description }}</h5>
            <div class="row">
                <div class="col-3">Boot</div>
                <div class="col">{{ $serviceRequest->boat->name }}</div>
            </div>
            <div class="row mt-3 mb-2">
                <x-invoice-konto />
            </div>

        @foreach($serviceRequest->services as $service)
            <div class="row">
                <div class="col-4"><strong>{{ $service->name }}</strong></div>
                <div class="col">Arbeitspreis {{ ($service->getServicePrice($serviceRequest->boat)) }} € ({{ $service->price }} € {{ $service->priceType->name }})</div>
            </div>
            @if($service->materials && $service->materials->count() > 0)
                <div class="row">
                    <div class="col-3">Material</div>
                    <div class="col-auto">
                        <ul class="list-disc ml-3">
                            @foreach($service->materials as $material)
                                <li>{{ $material->name }}</li>
                                <li>Preis: {{ $material->price_per_unit }} € pro {{ $material->priceType->unit }}</li>
                                <li>Ergiebigkeit: {{ $material->fertility }} {{ $material->fertility_unit }} pro {{ $material->fertility_per }}</li>
                                <li>benötigte Materialmenge: {{ round($material->getQuantity($serviceRequest->boat),1) }} {{ $material->fertility_per }}</li>
                                <li>berechneter Materialpreis: {{ round($material->getMaterialPrice($serviceRequest->boat),1) }} €</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @endforeach
            <div class="row mt-3 my-3 fs-5 font-extrabold">
                <div class="col-12">
                    Gesamtpreis: Netto: {{ ceil($serviceRequest->nettoPrice()) }} €, Brutto{{ ceil($serviceRequest->totalPrice()) }} €
                </div>
            </div>
            <br>
            <x-invoice-footer />
        </div>
    </div>
@endsection
