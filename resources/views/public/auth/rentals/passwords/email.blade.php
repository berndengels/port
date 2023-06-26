@extends('layouts.main')

@section('main')
	<div class="row m-sm-2 m-md-5 align-self-center">
		<div class="m-auto col-sm-12 col-md-6 align-content-center">
			<h1 class="m-3 fs-3 dark-grey">{{ __('auth.Reset Password') }}</h1>
			<div class="">
				<x-form class="w-full mx-3 md:w-1/2" method="POST" action="{{ route('customer.password.email') }}">
					<x-form-input type="email" name="email" label="Email" required/>
					<x-form-submit name="submit"
								   class="mt-3 btn btn-secondary">{{ __('Sende Passwort Reset-Link') }}</x-form-submit>
				</x-form>
			</div>
		</div>
	</div>
@endsection
