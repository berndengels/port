@extends('layouts.main')

@section('main')
	<div class="index-header mt-3 p-0">
		<div class="ms-0">
			<x-btn-create route="{{ route('customer.craneDates.create') }}"/>
		</div>
		<div></div>
	</div>
	<div id="craneDates"></div>
@endsection
