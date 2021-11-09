@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3">
            <div>
                <x-nav-link
                    href="{{ route('customer.boatDates.create') }}"
                    class="btn"
                    icon="far fa-plus-square"
                    text="Neueintrag"
                />
            </div>
            <div></div>
        </div>
        <div class="mx-5 mt-3">
            <!--span class="font-extrabold text-xl text-blue-900">{{-- 'saison' === $modus ? 'Sommerliegeplatz' : 'Winterlager' --}}</span-->
        </div>
        {{ $data->links() }}
        <table class="table w-full mt-3">
            <tr>
                <th class="hidden md:table-cell">ID</th>
                <th>Boot</th>
                <th>Von</th>
                <th>Bis</th>
                <th>Preis</th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td class="hidden md:table-cell">{{ $item->id }}</td>
                    <td><a href="{{ route('customer.boatDates.show', $item) }}">{{ $item->boat->boat_name }}</a></td>
                    <td>{{ $item->from->format('d.m.Y') }}</td>
                    <td>{{ $item->until->format('d.m.Y') }}</td>
                    <td>{{ $item->price }} €</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="9">
                    <div class="mt-3 w-full text-red-700">Summe Preis: {{ $priceTotal }} €</div>
                </th>
            </tr>
        </table>
        {{ $data->links() }}
    </div>
@endsection
