@extends('layouts.main')

@section('main')
    <div class="flex-container-dashboard public bg-main">
        <div class="flex-item-dashboard p-3 widget">
            <div class="title weatherTitle">Wetter</div>
            <div class="content mt-2 weather"></div>
        </div>
        <x-open-sea-map />
        @if($widgets->count() > 0)
            @foreach($widgets as $item)
            <x-widget :title="$item->title" :content="$item->content" />
            @endforeach
        @endif
    </div>
@endsection

@push('inline-scripts')
    <script>
        Weather.get('.flex-container-dashboard .widget .weather');
    </script>
@endpush
