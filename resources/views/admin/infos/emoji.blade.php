@extends('layouts.main')

@section('main')
    <div class="mt-5 emoji-list">
        @foreach($data as $item)
            <span class="m-2 emoji-item inline-flex">
                {{ $item }}
            </span>
        @endforeach
    </div>
@endsection


