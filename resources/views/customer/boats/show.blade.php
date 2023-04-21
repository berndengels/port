@extends('layouts.main')

@section('main')
    <div class="align-content-center">
        <div class="clearfix">
            <div class="float-start">
                <x-btn-back route="{{ route('customer.boats.index') }}" />
            </div>
        </div>
        <div class="container mt-3 ms-0 ps-2 ps-lg-0">
            <div class="row gy-3 ps-0">
                <div class="col-11 col-lg-4">
                    <div class="card">
                        <div class="card-header"><trong>Boot {{ $boat->name }}</trong></div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-5">Type</div>
                                <div class="col-auto">{{ __($boat->type) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-5">Länge</div>
                                <div class="col-auto">{{ $boat->length }} m</div>
                            </div>
                            <div class="row">
                                <div class="col-5">Breite</div>
                                <div class="col-auto">{{ $boat->width }} m</div>
                            </div>
                            <div class="row">
                                <div class="col-5">Gewicht</div>
                                <div class="col-auto">{{ $boat->weight/1000 }} T</div>
                            </div>
                            <div class="row">
                                <div class="col-5">Breite</div>
                                <div class="col-auto">{{ $boat->width }} m</div>
                            </div>
                            <div class="row">
                                <div class="col-5">Bordhöhe</div>
                                <div class="col-auto">{{ $boat->board_height }} m</div>
                            </div>
                            <div class="row">
                                <div class="col-5">Länge Wasserlinie</div>
                                <div class="col-auto">{{ $boat->length_waterline }} m</div>
                            </div>
                            <div class="row">
                                <div class="col-5">Tiefgang</div>
                                <div class="col-auto">{{ $boat->draft }} m</div>
                            </div>
                        </div>
                    </div>
                </div>

                @if('sail' === $boat->type)
                    <div class="col-11 col-lg-4">
                        <div class="card">
                            <div class="card-header"><trong>Segelboot Daten</trong></div>
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-3">Mastlänge</div>
                                    <div class="col-auto">{{ $boat->mast_length }} m</div>
                                </div>
                                <div class="row">
                                    <div class="col-3">Mastgewicht</div>
                                    <div class="col-auto">{{ $boat->mast_weight }} Kg</div>
                                </div>
                                <div class="row">
                                    <div class="col-3">Kiellänge</div>
                                    <div class="col-auto">{{ $boat->length_keel }} m</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

