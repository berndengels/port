@extends('layouts.main')

@section('main')
    <div>
        <x-btn-back route="{{ route('admin.serviceRequests.index') }}" />
        <x-btn-print route="{{ route('admin.serviceRequests.print', $serviceRequest) }}" />
    </div>
    <div id="viewPrint">
        <table class="table m-10 show-table">
            <tr>
                <th>Boot:</th>
                <td>{{ $serviceRequest->boat->name }} (Eigner: {{ $serviceRequest->boat->customer->name }})</td>
            </tr>
            <tr>
                <th>Fläche Unterwasserschiff:</th>
                <td>{{ round($underwaterArea, 1) }} m²</td>
            </tr>
            <tr>
                <th>Fläche Bord über Wasserlinie:</th>
                <td>{{ round($boardArea, 1) }} m²</td>
            </tr>
            <tr>
                <th>Bootslänge:</th>
                <td>{{ $serviceRequest->boat->length }} m</td>
            </tr>
            <tr>
                <th>Bootsbreite:</th>
                <td>{{ $serviceRequest->boat->width }} m</td>
            </tr>
            <tr>
                <th>Kunden Bemerkung:</th>
                <td>{{ $serviceRequest->description }}</td>
            </tr>
            <tr>
                <th>Erstellt am:</th>
                <td>{{ $serviceRequest->created_at->format('d.m.Y H:i') }} Uhr</td>
            </tr>
            <tr>
                <th>Erwünschte Fertigstellung bis:</th>
                <td>{{ $serviceRequest->done_until->format('d.m.Y') }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="w-100 border-secondary mt-3">
                        <x-form method="post" :action="route('admin.serviceRequests.done', $serviceRequest)" class="row">
                            @method('post')
                            <div class="col-sm-4 col-md-2">
                                @bind($serviceRequest)
                                <x-form-checkbox name="done" label="Erledigt" />
                                @endbind
                            </div>
                            <div class="col-auto">
                                <x-form-submit floating type="submit" class="btn-sm btn-primary d-inline-block">Speichern</x-form-submit>
                            </div>
                        </x-form>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="my-3 p-2 text-lg font-extrabold bg-blue-800 text-white">Aufgaben</div>
                </td>
            </tr>

            @foreach($serviceRequest->services as $service)
                <tr>
                    <th>Service</th>
                    <td>{{ $service->name }}</td>
                </tr>
                <tr>
                    <th>berechneter Arbeitspreis</th>
                    <td>{{ ($service->getServicePrice($serviceRequest->boat)) }} € ({{ $service->price }} € {{ $service->priceType->name }})</td>
                </tr>
                @if($service->materials && $service->materials->count() > 0)
                    <tr>
                        <th class="align-text-top">Material</th>
                        <td>
                            <ul class="list-disc ml-3">
                                @foreach($service->materials as $material)
                                    <li>{{ $material->name }}</li>
                                    <li>Preis: {{ $material->price_per_unit }} € pro {{ $material->priceType->unit }}</li>
                                    <li>Ergiebigkeit: {{ $material->fertility }} {{ $material->fertility_unit }} pro {{ $material->fertility_per }}</li>
                                    <li>benötigte Materialmenge: {{ round($material->getQuantity($serviceRequest->boat),1) }} {{ $material->fertility_per }}</li>
                                    <li>berechneter Materialpreis: {{ round($material->getMaterialPrice($serviceRequest->boat),1) }} €</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endif
                <tr><td colspan="2"><hr></td></tr>
            @endforeach

            <tr>
                <td colspan="2">
                    <div class="w-100 my-3 p-2 fs-4 bg-red white">
                        Gesamtpreis {{ ceil($serviceRequest->totalPrice()) }} € (aufgerundet)
                    </div>
                </td>
            </tr>
        </table>
    </div>
@endsection
