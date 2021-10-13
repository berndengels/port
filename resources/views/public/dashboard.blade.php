@extends('layouts.main')

@section('main')
    <div class="flex-container-dashboard public">
        @if($widgets->count() > 0)
            @foreach($widgets as $item)
            <div class="flex-item-dashboard p-3 widget">
                <div class="title">{{ $item->title }}</div>
                <div class="content mt-2">{!! $item->content !!}</div>
            </div>
            @endforeach
        @endif
    </div>
@endsection
