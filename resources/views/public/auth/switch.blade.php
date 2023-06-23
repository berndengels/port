@extends('layouts.main')

@section('main')
	<div class="row m-sm-2 m-md-5 align-self-center">
		<div class="m-auto col-sm-12 col-md-6 align-content-center">
			<h1 class="m-3 fs-3 dark-grey">{{ __('Auswahl Registrierungsarten') }}</h1>
			<div>
				<x-form name="switch" class="w-half mx-3" method="get" action="{{ route('register') }}">
					<x-form-select id="type" name="type" label="Boots Typ" :options="$customerTypes" required/>
				</x-form>
			</div>
		</div>
	</div>
@endsection

@push('inline-scripts')
	<script>
		$(document).ready(() => {
			$('#type').change(e => {
				document.switch.submit();
			});
		});
	</script>
@endpush
