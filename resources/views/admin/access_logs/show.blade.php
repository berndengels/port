@extends('layouts.main')

@section('main')
	<div class="align-content-center">
		<div class="clearfix">
			<div class="float-start">
				<x-btn-back route="{{ route('admin.accessLogs.index') }}"/>
			</div>
		</div>

		<div class="container mt-3 ms-0 ps-2 ps-lg-0">
			<div class="row gy-3 ps-0">
				<div class="col-11 col-lg-4">
					<div class="card">
						<div class="card-header"><strong>Zugriff
								am {{ $accessLog->created_at->format('d.m.Y H:i') }}</strong></div>
						<div class="card-body p-3">
							<div class="row">
								<div class="col-3">Land</div>
								<div class="col-auto">{{ __($accessLog->country) }}</div>
							</div>
							<div class="row">
								<div class="col-3">Ort</div>
								<div class="col-auto">{{ $accessLog->city }}</div>
							</div>
							<div class="row">
								<div class="col-3">Bundesland</div>
								<div class="col-auto">{{ $accessLog->state }}</div>
							</div>
							<div class="row">
								<div class="col-3">PLZ</div>
								<div class="col-auto">{{ $accessLog->postal_code }}</div>
							</div>
							<div class="row">
								<div class="col-3">UserAgent</div>
								<div class="col-auto">{{ $accessLog->user_agent }}</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

