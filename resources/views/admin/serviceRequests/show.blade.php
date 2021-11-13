@extends('layouts.main')

@section('main')
    <div class="m-5">
        <x-nav-link :href="route('admin.serviceRequests.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
    </div>
    <table class="table m-10 show-table">
        <tr>
            <th>Boot:</th>
            <td>{{ $serviceRequest->boat->boat_name }} (Eigner: {{ $serviceRequest->boat->customer->name }})</td>
        </tr>
        <tr>
            <th>Fläche Unterwasserschiff:</th>
            <td>{{ round($underWaterShip, 1) }} m²</td>
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
            <th>Ist erledigt:</th>
            <td>{{ $serviceRequest->done ? 'Ja' : 'Nein' }}</td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="my-3 p-2 text-lg font-extrabold bg-blue-800 text-white">Aufgaben</div>
            </td>
        </tr>

        @foreach($serviceRequest->services as $service)
            <tr>
                <th>Name</th>
                <td>{{ $service->name }}</td>
            </tr>
            <tr>
                <th>berechneter Arbeitspreis</th>
                <td>{{ ceil($service->getServicePrice($serviceRequest->boat)) }} € ({{ $service->price }} € {{ $service->priceType->name }})</td>
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
                                <li>benötigte Materialmenge: {{ round($material->getQuantity($serviceRequest->boat), 1) }} {{ $material->fertility_per }}</li>
                                <li>berechneter Materialpreis: {{ round($material->getMaterialPrice($serviceRequest->boat)) }} €</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endif
            <tr><td colspan="2"><hr></td></tr>
        @endforeach

        <tr>
            <td colspan="2">
                <div class="my-3 p-2 text-lg font-extrabold bg-red-600 text-white">
                    Gesamtpreis {{ ($serviceRequest->totalPrice()) }} €
                </div>
            </td>
        </tr>

    </table>
@endsection

