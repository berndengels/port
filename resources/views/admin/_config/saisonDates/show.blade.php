@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.config-saisonDates-' . $route) }}"/>
	</div>
@endsection

