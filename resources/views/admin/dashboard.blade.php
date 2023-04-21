@extends('layouts.main')

@section('main-full')
<div class="container mt-3 ms-0 ps-2 ps-lg-0">
    <div class="flex-item-dashboard p-3 widget">
        <div class="title weatherTitle">Wetter</div>
        <div class="content mt-2 weather"></div>
    </div>

    <x-open-sea-map />

    @if($caravansFromToday && $caravansFromToday->count() > 0)
    <div class="flex-item-dashboard p-3 widget">
        <div class="title">Wohnmobile heute:</div>
        @foreach($caravansFromToday as $item)
            <div class="content carnumber">
                {{ $item }}
            </div>
        @endforeach
    </div>
    @endif
</div>
<x-tooltip id="tooltip" />
@endsection

@push('inline-scripts')
    <script>
	    const routePrefix = "{{ route('admin.car.info') }}";
	    Car.info(routePrefix, '.carnumber', '#tooltip');
	    Weather.get('.flex-container-dashboard .widget .weather');
    </script>
@endpush
