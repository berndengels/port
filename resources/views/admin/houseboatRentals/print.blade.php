@extends('layouts.print')

@section('main')
    <div class="container">
        <div class="w-100">
            <x-invoice-header class="mb-5" />
            <br>
            <br>
            <x-recipient-header class="mt-5" :recipient="$houseboatDate->customer" />
            <h5 class="w-100">Rechnung für Miete des Hausboots {{ $houseboatDate->houseboat->name }} vom {{ $houseboatDate->from->format('d.m.Y') }} bis {{ $houseboatDate->until->format('d.m.Y') }}</h5>
            <div class="row mt-3">
                <div class="col-3">Hausboot</div>
                <div class="col">{{ $houseboatDate->houseboat->name }}</div>
            </div>
            <div class="row">
                <div class="col-3">Mieter</div>
                <div class="col">{{ $houseboatDate->customer->name }}</div>
            </div>
            <div class="row">
                <div class="col-3">Anzahl Tage</div>
                <div class="col">{{ $priceData->days }}</div>
            </div>
            <div class="row">
                <div class="col-3">Basis-Preis</div>
                <div class="col"><b>{{ $priceData->priceBase }} €</b></div>
            </div>

            @isset($priceData->netto)
            <div class="row">
                <div class="col-3">MWSt-Satz</div>
                <div class="col"><b>{{ $priceData->tax }} %</b></div>
            </div>
                <div class="row">
                    <div class="col-3">MWSt</div>
                    <div class="col"><b>{{ $priceData->taxPrice }} €</b></div>
                </div>
            <div class="row">
                <div class="col-3">Netto-Preis</div>
                <div class="col"><b>{{ $priceData->netto }} €</b></div>
            </div>
            @endisset

            <div class="row">
                <div class="col-3">Gesamt-Preis</div>
                <div class="col"><b>{{ $priceData->total }} €</b></div>
            </div>
            <div class="row mt-3">
                <x-invoice-konto />
            </div>
            <div class="row">
                <div class="col-auto">
                    <h3>Tages Preise</h3>
                    <table class="table table-sm table-striped w-100 ms-0">
                        <tr>
                            <th>{{ __('Datum') }}</th>
                            <th>{{ __('Saison') }}</th>
                            <th>{{ __('Feiertag') }}</th>
                            <th>{{ __('Preis') }}</th>
                        </tr>
                        @foreach($priceData->dailyPrices as $item)
                            <tr>
                                <td>{{ $item->date }}</td>
                                <td>{{ __($item->saison) }}</td>
                                <td>{{ $item->holiday ?? '' }}</td>
                                <td>{{ $item->price }} €</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <br>
            <x-invoice-footer />
        </div>
    </div>
@endsection
