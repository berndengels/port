@extends('layouts.main')

@section('main')
	<div class="index-header mt-3 p-0">
		<div class="ms-0">
			<x-btn-create route="{{ route('admin.craneDates.create') }}"/>
		</div>
		<div></div>
	</div>
	<div id="adminCraneDates"></div>
@endsection
