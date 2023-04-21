@extends('layouts.pure')

@section('main')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h2>Simple QR Code</h2>
            </div>
            <div class="card-body">
                <img src="{{ asset($imgUrl) }}" />
            </div>
        </div>
    </div>
@endsection
