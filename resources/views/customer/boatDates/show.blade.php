@extends('layouts.main')

@section('main')
    <div class="m-5 content-center w-3/4">
        <div class="w-full block">
            <div class="float-left">
                <x-nav-link href="{{ route('customer.boatDates.index') }}" icon="fas fa-backward" class="btn">zur Liste</x-nav-link>
            </div>
            <div class="float-right">
                <x-nav-link href="{{ route('customer.boatDates.invoice', $boatDate) }}" icon="fas fa-edit" class="btn" title="Rechnung senden">
                    <span class="hidden md:visible">Rechnung senden</span>
                </x-nav-link>
            </div>
        </div>

        <div class="show-page mt-3">
            <div>
                <div>Boot</div>
                <div>{{ $boatDate->boat->boat_name }}</div>
            </div>
            <div>
                <div>Art</div>
                <div>{{ config('port.main.boat.dates.modi')[$boatDate->modus] }}</div>
            </div>
            <div>
                <div>Von</div>
                <div>{{ $boatDate->from->format('d.m.Y') }}</div>
            </div>
            <div>
                <div>Bis</div>
                <div>{{ $boatDate->until->format('d.m.Y') }}</div>
            </div>

            @foreach(json_decode($boatDate->prices, true) as $label => $val)
                @if('total' === $label)
                    @continue
                @endif
            <div>
                <div>{{ __($label) }}</div>
                <div>{{ $val }} @if(0 === strpos($val, 'price', 0)) € @endif</div>
            </div>
            @endforeach

            <div>
                <div>Gesamt-Preis</div>
                <div><b>{{ $boatDate->price }} €</b></div>
            </div>
        </div>
    </div>
@endsection
