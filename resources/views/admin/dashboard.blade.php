@extends('layouts.main')

@section('main')
<div class="flex-container-dashboard admin">

    <div class="flex-item-dashboard p-3 widget">
        <div class="title">Wetter</div>
        <div class="content mt-2 weather"></div>
    </div>

    @if($caravansFromToday && $caravansFromToday->count() > 0)
    <div class="flex-item-dashboard p-3 widget">
        <h3>Wohnmobil heute:</h3>
        @foreach($caravansFromToday as $item)
            <div class="carnumber">
                {{ $item }}
            </div>
        @endforeach
    </div>
    @endif

    <div class="flex-item-dashboard p-0">
        <x-open-sea-map class="w-full h-full" lat="{{ $map['lat'] }}" lng="{{ $map['lng'] }}" zoom="{{ $map['zoom'] }}" />
    </div>
</div>
@endsection

@push('inline-scripts')
    <script>
		Weather.get('.flex-container-dashboard .widget .weather');
    </script>
@endpush
