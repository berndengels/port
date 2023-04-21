@extends('layouts.main')

@section('main')
    <div>
        <x-btn-back route="{{ route('admin.saisonDates.' . (isset($route) ? $route : 'index')) }}" />
    </div>
@endsection

