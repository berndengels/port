@extends('layouts.main')

@section('main')
	<div class="m-5">
        <span class="text-blue">
            {{ $message ?? '' }}
        </span>
	</div>
@endsection
