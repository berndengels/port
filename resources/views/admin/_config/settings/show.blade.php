@extends('layouts.main')

@section('main')
    @if(!$data)
    <div class="container mt-4">
        <x-btn-create route="{{ route('admin.config.settings.create') }}" />
    </div>

    @else

    <div class="container mt-4 ms-0 ps-2 ps-lg-0">
        <div class="row gy-3 ps-0">
            <div class="col-11 col-lg-5">
                <div class="card">
                    <div class="card-header"><strong>Name {{ $data->name }}</strong></div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-3">Adresse</div>
                            <div class="col-auto">{{ $data->postcode }} {{ $data->location }}, {{ $data->street }}</div>
                        </div>
                        <div class="row">
                            <div class="col-3">Fon</div>
                            <div class="col-auto">{{ $data->fon }}</div>
                        </div>
                        <div class="row">
                            <div class="col-3">Email</div>
                            <div class="col-auto">{{ $data->email }}</div>
                        </div>
                        <div class="row">
                            <div class="col-3">Latitude</div>
                            <div class="col-auto">{{ $data->lat }}</div>
                        </div>
                        <div class="row">
                            <div class="col-3">Longitude</div>
                            <div class="col-auto">{{ $data->lng }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-11 col-lg-5">
                <div class="card">
                    <div class="card-header"><strong>Konto {{ $data->bank }}</strong></div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-4">BIC</div>
                            <div class="col-auto">{{ $data->bic }}</div>
                        </div>
                        <div class="row">
                            <div class="col-4">IBAN</div>
                            <div class="col-auto">{{ $data->iban }}</div>
                        </div>
                        <div class="row">
                            <div class="col-4">MWSt</div>
                            <div class="col-auto">{{ $data->tax }} %</div>
                        </div>
                        <div class="row">
                            <div class="col-4">MWSt anrechnen</div>
                            <div class="col-auto">{{ $data->use_tax ? 'Ja' : 'Nein' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mt-3">
                <x-btn-edit route="{{ route('admin.config.settings.edit', $data) }}" />
                <x-btn-delete route="{{ route('admin.config.settings.destroy', $data) }}" />
            </div>
        </div>
    </div>
    @endif
@endsection

