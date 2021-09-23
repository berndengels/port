@extends('layouts.main')

@section('main')
<div class="flex-container-dashbord">
    @if($caravansFromToday && $caravansFromToday->count() > 0)
    <div class="flex-item-dashbord p-3">
        <h3>Wohnwagen heute:</h3>
        @foreach($caravansFromToday as $item)
        <div class="flex flex-wrap flex-shrink-0 carnumber">
            {{ $item }}
        </div>
        @endforeach
    </div>
    @endif

    <div class="flex-item-dashbord p-0">
        <x-open-sea-map class="w-full h-full" lat="{{ $map['lat'] }}" lng="{{ $map['lng'] }}" zoom="{{ $map['zoom'] }}" />
    </div>
</div>

@endsection
