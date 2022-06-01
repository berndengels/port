@extends('layouts.main')

@section('main')
    <div class="m-5 content-center w-10/12">
        <div class="w-full block">
            <div class="float-left">
                <x-nav-link href="{{ route('admin.houseboatDates.index') }}" icon="fas fa-backward" class="btn">zur Liste</x-nav-link>
                <x-nav-link href="{{ route('admin.houseboatDates.edit', $houseboatDate) }}" icon="fas fa-edit" class="btn bg-blue-500 ml-3">Edit</x-nav-link>
            </div>
            <div class="float-right">
                <x-nav-link target="_blank" href="{{ route('admin.houseboatDates.print', $houseboatDate) }}" icon="fas fa-print" class="btn" title="Drucken">
                    <span class="hidden md:visible">Drucken</span>
                </x-nav-link>
                <x-nav-link target="_blank" href="{{ route('admin.houseboatDates.sendInvoice', $houseboatDate) }}" icon="fas fa-edit" class="btn ml-3" title="Rechnung senden">
                    <span class="hidden md:visible">Rechnung senden</span>
                </x-nav-link>
            </div>
        </div>

        <div class=" show-page mt-3">
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
                <div><a href="mailto:{{ $houseboatDate->customer->email }}" target="_blank">{{ $houseboatDate->customer->email }}</a></div>
            </div>
            <div>
                <div>Fon</div>
                <div>
                    @if($houseboatDate->customer->fon)
                        <a href="tel:{{ $houseboatDate->customer->fon }}" target="_blank">
                            <i class="fas fa-phone"></i>
                            {{ $houseboatDate->customer->fon }}
                        </a>
                    @endif
                </div>
            </div>
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
