@extends('layouts.main')

@section('main')
    <div class="flex-container-dashboard public">
        <div class="flex-item-dashboard p-3 widget">
            <div class="title">Wetter</div>
            <div class="content mt-2 weather"></div>
        </div>
        @if($widgets->count() > 0)
            @foreach($widgets as $item)
            <x-widget :data="$item" />
            @endforeach
        @endif
    </div>
@endsection

@push('inline-scripts')
    <script>
        Weather.get('.flex-container-dashboard .widget .weather');
    </script>
@endpush
