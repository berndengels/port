@extends('layouts.main')

@section('main')
    <div class="align-content-center">
        <div class="clearfix">
            <div class="float-start">
                <x-btn-back route="{{ route('customer.serviceRequests.index') }}" />
            </div>
            <div class="float-end">
                <x-btn-print route="{{ route('customer.serviceRequests.print', $serviceRequest) }}" />
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3 ms-0 ps-2 ps-lg-0">
        <div class="row gy-3 ps-0">
            <div class="col-11 col-lg-4">
                <div class="card">
                    <div class="card-header"><trong>Boot {{ $serviceRequest->boat->name }}</trong></div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-6">Type</div>
                            <div class="col-auto">{{ __($serviceRequest->boat->type) }}</div>
                        </div>
                        <div class="row">
                            <div class="col-6">Fläche Unterwasserschiff</div>
                            <div class="col-auto">{{ round($underwaterArea, 1) }} m²</div>
                        </div>
                        <div class="row">
                            <div class="col-6">Fläche Bord über Wasserlinie</div>
                            <div class="col-auto">{{ $serviceRequest->boat->width }} m</div>
                        </div>
                        <div class="row">
                            <div class="col-6">Bootsbreite</div>
                            <div class="col-auto">{{ $serviceRequest->boat->width }} m</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-11 col-lg-4">
                <div class="card">
                    <div class="card-header"><trong>Auftrags Daten</trong></div>
                    <div class="card-body p-3">
                        <div class="row pe-3">
                            <div class="col-12"><strong class="text-primary">{!! $serviceRequest->description !!}</strong></div>
                        </div>
                        <div class="row">
                            <div class="col-6">Erstellt am</div>
                            <div class="col-auto">{{ $serviceRequest->created_at->format('d.m.Y H:i') }} Uhr</div>
                        </div>
                        <div class="row">
                            <div class="col-6">gewünschte Fertigstellung</div>
                            <div class="col-auto">{{ $serviceRequest->done_until->format('d.m.Y') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-6">Ist erledigt</div>
                            <div class="col-auto">{{ $serviceRequest->done ? 'Ja' : 'Nein' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-11 col-lg-2">
                <x-sum-price :brutto="$serviceRequest->totalPrice()" />
            </div>

            <h3 class="text-dark mb-0 mp-0">Aufgaben</h3>

        @foreach($serviceRequest->services as $service)
            <div class="col-11 col-lg-4">
                <div class="card">
                    <div class="card-header"><strong>{{ $service->name }}</strong></div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-4">Arbeitspreis</div>
                            <div class="col-auto">{{ ($service->getServicePrice($serviceRequest->boat)) }} € ({{ $service->price }} € {{ $service->priceType->name }})</div>
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
                    </div>
                </div>
            </div>
        @endforeach

        <!--div class="row">
            <div class="col-auto my-3 p-2 fs-3 font-extrabold">
                Gesamtpreis: Netto: {{ ceil($serviceRequest->nettoPrice()) }} €, Brutto: {{ ceil($serviceRequest->totalPrice()) }} €
            </div>
        </div-->
    </div>
@endsection

