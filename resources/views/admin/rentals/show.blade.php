@extends('layouts.main')

@section('main')
    <div>
        <div class="clearfix">
            <div class="float-start">
                <x-btn-back route="{{ route('admin.'.$routeName.'.index') }}" />
                <x-btn-edit route="{{ route('admin.'.$routeName.'.edit', $rental) }}" />
            </div>
            <div class="float-end">
                <x-btn-print route="{{ route('admin.'.$routeName.'.print', $rental) }}" />
                <x-btn-invoice route="{{ route('admin.'.$routeName.'.sendInvoice', $rental) }}" />
            </div>
        </div>
        <div class="container mt-3 ms-0 ps-2 ps-lg-0">
            <div class="row gy-3 ps-0">

                <div class="col-11 col-lg-4">
                    <div class="card">
                        <div class="card-header"><strong>{{ __(ucfirst($relationName)) }} {{ $rental->rentable->name }}</strong></div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-3">Mieter</div>
                                <div class="col-auto">{{ $rental->customer->name }}</div>
                            </div>
                            <div class="row">
                                <div class="col-3">Email</div>
                                <div class="col-auto"><a href="mailto:{{ $rental->customer->email }}" target="_blank">
                                        <i class="fas fa-mail"></i>
                                        {{ $rental->customer->email }}
                                    </a></div>
                            </div>
                            <div class="row">
                                <div class="col-3">Fon</div>
                                <div class="col-auto">
                                    @if($rental->customer->fon)
                                        <a href="tel:{{ $rental->customer->fon }}" target="_blank">
                                            <i class="fas fa-phone"></i>
                                            {{ $rental->customer->fon }}
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
                                <div class="col-auto">{{ $rental->from->translatedFormat('l d.m.Y') }}</div>
                            </div>
                            <div class="row">
                                <div class="col-2">Bis</div>
                                <div class="col-auto">{{ $rental->until->translatedFormat('l d.m.Y') }}</div>
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
