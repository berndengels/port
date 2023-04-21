@extends('layouts.main')

@section('main')
    <div>
        <div class="clearfix">
            <div class="float-start">
                <x-btn-back route="{{ route('admin.rentals.index') }}" />
                <x-btn-edit route="{{ route('admin.rentals.edit', $houseboatDate) }}" />
            </div>
            <div class="float-end">
                <x-btn-print route="{{ route('admin.rentals.print', $houseboatDate) }}" />
                <x-btn-invoice :route="route('admin.rentals.sendInvoice', $houseboatDate)" />
            </div>
        </div>

        <div class="container mt-3 ms-0 ps-2 ps-lg-0">
            <div class="row gy-3 ps-0">

                <div class="col-11 col-lg-4">
                    <div class="card">
                        <div class="card-header"><trong>Hausboot {{ $houseboatDate->houseboat->name }}</trong></div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-3">Mieter</div>
                                <div class="col-auto">{{ $houseboatDate->customer->name }}</div>
                            </div>
                            <div class="row">
                                <div class="col-3">Email</div>
                                <div class="col-auto"><a href="mailto:{{ $houseboatDate->customer->email }}" target="_blank">
                                        <i class="fas fa-mail"></i>
                                        {{ $houseboatDate->customer->email }}
                                    </a></div>
                            </div>
                            <div class="row">
                                <div class="col-3">Fon</div>
                                <div class="col-auto">
                                    @if($houseboatDate->customer->fon)
                                        <a href="tel:{{ $houseboatDate->customer->fon }}" target="_blank">
                                            <i class="fas fa-phone"></i>
                                            {{ $houseboatDate->customer->fon }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-11 col-lg-3">
                    <div class="card">
                        <div class="card-header"><strong>Vermietung für {{ $priceData->days }} Tage</strong></div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-2">Von</div>
                                <div class="col-auto">{{ $houseboatDate->from->format('d.m.Y') }}</div>
                            </div>
                            <div class="row">
                                <div class="col-2">Bis</div>
                                <div class="col-auto">{{ $houseboatDate->until->format('d.m.Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-11 col-lg-5">
                    <div class="card">
                        <div class="card-header"><strong>Tages Preise</strong></div>
                        <div class="card-body p-3">
                            <table class="">
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

                            @isset($priceData->netto)
                                <div class="row">
                                    <div class="col-3">MWSt-Satz</div>
                                    <div class="col"><strong>{{ $priceData->tax }} %</strong></div>
                                </div>
                            <div class="row">
                                <div class="col-3">MWSt</div>
                                <div class="col"><strong>{{ $priceData->taxPrice }} €</strong></div>
                            </div>
                            <div class="row">
                                <div class="col-3">Netto-Preis</div>
                                <div class="col"><strong>{{ $priceData->netto }} €</strong></div>
                            </div>
                            @endisset

                            <div class="row">
                                <div class="col-3">Gesamt-Preis</div>
                                <div class="col"><strong>{{ $priceData->total }} €</strong></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
