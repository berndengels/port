@php use Carbon\Carbon; @endphp
@extends('layouts.print')

@section('main')
    <div class="container justify-content-center">
        <div class="w-100">
            <x-invoice-header class="mb-5" />
            <br>
            <br>
            <x-recipient-header class="mt-5" :recipient="$boatDate->boat->customer" />

            <h5 class="w-100">Rechnung für Dauerliegeplatz Saison: {{ __($boatDate->modus) }} ab {{ $boatDate->from->format('Y') }} bis {{ $boatDate->until->format('d.m.Y') }}</h5>
            <div class="row mt-3">
                <div class="col-3">Datum</div>
                <div class="col">{{ Carbon::today()->format('d.m.Y') }}</div>
            </div>
            <div class="row">
                <div class="col-3">Boot</div>
                <div class="col">{{ $boatDate->boat->name }}</div>
            </div>
            <div class="row">
                <div class="col-3">Eigner</div>
                <div class="col">{{ $boatDate->boat->customer->name }}</div>
            </div>
            <div class="row">
                <div class="col-3">Anzahl Tage</div>
                <div class="col">{{ $priceData->days }}</div>
            </div>
            <div class="row mt-3">
                <x-invoice-konto />
            </div>
            <!--div class="row">
                <div class="col-3">Preise</div>
                <div class="col-auto">
                    <table class="table table-sm table-striped">
                        <tr>
                            <th>{{ __('Service') }}</th>
                            <th>{{ __('Preis') }}</th>
                        </tr>
                        @foreach($priceData as $service => $item)
                            @continue('days' === $service)
                            <tr>
                                <td>{{ __($service) }}</td>
                                <td>{{ $item }} €</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div-->
            <x-invoice-guest-prices :prices="$priceData" />
            <br>
            <x-invoice-footer />
        </div>
    </div>
@endsection
