@extends('layouts.main')

@section('main')
    <div class="align-content-center">
        <div class="container mt-3 ms-0 ps-2 ps-lg-0">
            <div class="row gy-3 ps-0">
                <div class="col-11 col-lg-4">
                    <div class="card">
                        <div class="card-header"><strong>Name {{ $profile->name }}</strong></div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-3">Email</div>
                                <div class="col-auto">{{ $profile->email }}</div>
                            </div>
                            <div class="row">
                                <div class="col-3">Fon</div>
                                <div class="col-auto">{{ $profile->fon }}</div>
                            </div>
                            <div class="row">
                                <div class="col-3">Strasse</div>
                                <div class="col-auto">{{ $profile->street }}</div>
                            </div>
                            <div class="row">
                                <div class="col-3">PLZ</div>
                                <div class="col-auto">{{ $profile->postcode }}</div>
                            </div>
                            <div class="row">
                                <div class="col-3">Ort</div>
                                <div class="col-auto">{{ $profile->city }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <x-btn-edit route="{{ route('customer.profile.edit', $profile) }}" />
        </div>
    </div>
@endsection

