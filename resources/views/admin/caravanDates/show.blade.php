@extends('layouts.main')

@section('main')
    <div class="m-5 content-center">
        <x-nav-link :href="route('admin.caravanDates.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <table class="table mt-5">
            <tr>
                <th class="text-right">Kennzeichen</th>
                <td><span class="carnumber cursor-pointer">{{ $caravanDate->caravan->carnumber }}</span></td>
            </tr>
            <tr>
                <th class="text-right">Wagenlänge</th>
                <td>{{ $caravanDate->caravan->carlength }} m</td>
            </tr>
            <tr>
                <th class="text-right">Personen</th>
                <td>{{ $caravanDate->persons }}</td>
            </tr>
            <tr>
                <th class="text-right">Strom-Anschluß</th>
                <td>{{ $caravanDate->electric ? 'JA' : 'Nein'}}</td>
            </tr>
        @foreach(json_decode($caravanDate->prices, true) as $prop => $data)
            @if( is_string($prop) && (is_string($data) || is_int($data)))
            <tr>
                <th class="text-right">{{ __($prop) }}</th>
                <td>{{ $data }} @if(preg_match("/price|total/i", $prop)) € @endif</td>
            </tr>
            @endif
        @endforeach
        </table>
    </div>
    <x-tooltip id="tooltip" />
@endsection

@push('inline-scripts')
    <script>
        const routePrefix = "{{ route('admin.car.info') }}"
        Car.info(routePrefix, '.carnumber', '#tooltip')
    </script>
@endpush


