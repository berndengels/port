@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.configSaisonDates-' . $route) }}"/>
	</div>
@endsection

