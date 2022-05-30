@extends('layouts.print')

@section('main')
    <div class="m-5 content-center w-full">
        <div class="show-page mt-3">
            <div>
                <div>Hausboot</div>
                <div>{{ $houseboatDate->houseboat->name }}</div>
            </div>
            <div>
                <div>Mieter</div>
                <div>{{ $houseboatDate->customer->name }}</div>
            </div>
            <div>
                <div>Email</div>
                <div>{{ $houseboatDate->customer->email }}</div>
            </div>

            @if($houseboatDate->customer->fon)
            <div>
                <div>Fon</div>
                <div>{{ $houseboatDate->customer->fon }}</div>
            </div>
            @endif

            <div>
                <div>Von</div>
                <div>{{ $houseboatDate->from->format('d.m.Y') }}</div>
            </div>
            <div>
                <div>Bis</div>
                <div>{{ $houseboatDate->until->format('d.m.Y') }}</div>
            </div>
            <div>
                <div>Anzahl Tage</div>
                <div>{{ $days }}</div>
            </div>

            <div>
                <div>Tages Preise</div>
                <div class="ml-0">
                    <table class="">
                        <tr>
                            <th>{{ __('Datum') }}</th>
                            <th>{{ __('Saison') }}</th>
                            <th>{{ __('Feiertag') }}</th>
                            <th>{{ __('Preis') }}</th>
                        </tr>
                        @foreach($dailyPrices as $item)
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

            <div>
                <div>Gesamt-Preis</div>
                <div><b>{{ $priceTotal }} €</b></div>
            </div>
        </div>
    </div>
@endsection

@push('inline-scripts')
    <script>
        window.onload = function() {
	        this.print();
			history.back();
        }
    </script>
@endpush
