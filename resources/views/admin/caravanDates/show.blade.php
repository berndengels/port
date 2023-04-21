@php use Carbon\Carbon; @endphp
@extends('layouts.main')

@section('main')
    <div class="align-content-center">
        <div class="clearfix">
            <div class="float-start">
                <x-btn-back route="{{ route('admin.caravanDates.index') }}" />
            </div>
            <div class="float-end">
                <x-btn-print route="{{ route('admin.caravanDates.print', $caravanDate) }}" />
                @if($caravanDate->caravan->email)
                <x-btn-invoice :route="route('admin.caravanDates.sendInvoice', $caravanDate)" />
                @endif
            </div>
        </div>

        <div class="container mt-3 ms-0 ps-2 ps-lg-0">
            <div class="row gy-3 ps-0">
                <div class="col-11 col-lg-4">
                    <div class="card">
                        <div class="card-header"><strong>Caravan {{ $caravanDate->caravan->carnumber }}</strong></div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-3">Länge</div>
                                <div class="col-auto">{{ $caravanDate->caravan->carlength }} m</div>
                            </div>
                            <div class="row">
                                <div class="col-3">Personen</div>
                                <div class="col-auto">{{ $caravanDate->persons }}</div>
                            </div>
                            <div class="row">
                                <div class="col-3">Strom</div>
                                <div class="col-auto">{{ $caravanDate->electric ? 'JA' : 'Nein'}}</div>
                            </div>
                            <div class="row">
                                <div class="col-3">Anreise</div>
                                <div class="col-auto">{{ $caravanDate->from->translatedFormat('l d.m.Y') }}</div>
                            </div>
                            <div class="row">
                                <div class="col-3">Abreise</div>
                                <div class="col-auto">{{ $caravanDate->until->translatedFormat('l d.m.Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-11 col-lg-4">
                    <x-show-guest-prices :prices="$priceData" />
                </div>
            </div>
        </div>
    </div>
    <x-tooltip id="tooltip" />
@endsection

@push('inline-scripts')
<script>
    const routePrefix = "{{ route('admin.car.info') }}";
    Car.info(routePrefix, '.carnumber', '#tooltip')
</script>
@endpush


