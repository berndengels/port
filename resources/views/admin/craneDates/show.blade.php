@extends('layouts.main')

@section('main')
	<div class="align-content-center">
		<div class="clearfix">
			<div class="float-start">
				<x-btn-back route="{{ route('admin.craneDates.index') }}"/>
			</div>
			<div class="float-end">
			</div>
		</div>
		<div class="container mt-3 ms-0 ps-2 ps-lg-0">
			<div class="row gy-3 ps-0">
				<div class="col-11 col-lg-4">
					<div class="card">
						<div class="card-header"><strong>Boot {{ $craneDate->boat->name }}</strong></div>
						<div class="card-body p-3">
							<div class="row">
								<div class="col-3">Eigner</div>
								<div class="col-auto">{{ $craneDate->customer->name }}</div>
							</div>
							<div class="row">
								<div class="col-3">Datum</div>
								<div class="col-auto">{{ $craneDate->crane_date->isoFormat('dddd D.M.Y') }}</div>
							</div>
							<div class="row">
								<div class="col-3">Uhrzeit</div>
								<div class="col-auto">{{ $craneDate->crane_time }} Uhr</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

