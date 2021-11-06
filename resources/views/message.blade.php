@extends('layouts.main')

@section('main')
    <div class="m-5">
        <span class="text-blue-900 text-2xl">
            {{ $message ?? '' }}
        </span>
    </div>
@endsection
