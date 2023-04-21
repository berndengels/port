@php use Carbon\Carbon; @endphp
@extends('layouts.main')

@section('main')
<div class="align-content-center">
    <div class="clearfix">
        <div class="float-start">
            <x-btn-back route="{{ route('admin.guestBoatDates.index') }}" />
        </div>
        <div class="float-end">
            <x-btn-print route="{{ route('admin.guestBoatDates.print', $guestBoatDate) }}" />
            @if($guestBoatDate->boat->email)
                <x-btn-invoice :route="route('admin.guestBoatDates.sendInvoice', $guestBoatDate)" />
            @endif
        </div>
    </div>

    <div class="container mt-3 ms-0 ps-2 ps-lg-0">
        <div class="row gy-3 ps-0">
            <div class="col-11 col-lg-4">
                <div class="card">
                    <div class="card-header"><trong>Bootsname {{ $guestBoatDate->boat->name }}</trong></div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-3">Liegeplatz</div>
                            <div class="col-auto">{{ $guestBoatDate->berth?->dock->name ?? null }} {{ $guestBoatDate->berth?->name ?? null }}</div>
                        </div>
                        <div class="row">
                            <div class="col-3">Länge</div>
                            <div class="col-auto">{{ $guestBoatDate->boat->length }} m</div>
                        </div>
                        <div class="row">
                            <div class="col-3">Personen</div>
                            <div class="col-auto">{{ $guestBoatDate->persons }}</div>
                        </div>
                        <div class="row">
                            <div class="col-3">Strom</div>
                            <div class="col-auto">{{ $guestBoatDate->electric ? 'JA' : 'Nein'}}</div>
                        </div>
                        <div class="row">
                            <div class="col-3">Anreise</div>
                            <div class="col-auto">{{ $guestBoatDate->from->translatedFormat('l d.m.Y') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-3">Abreise</div>
                            <div class="col-auto">{{ $guestBoatDate->until->translatedFormat('l d.m.Y') }}</div>
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

