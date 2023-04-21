@extends('layouts.main')

@section('main')
    <div class="container m-3">
        <div class="page">{!! $data->content !!}</div>
    </div>
@endsection

