@extends('layouts.main')

@section('main')
	<div class="row m-sm-2 m-md-5 align-self-center">
		<div class="m-auto col-sm-12 col-md-6 align-content-center">
			<h1 class="m-3 fs-3 dark-grey">{{ __('auth.Reset Password') }}</h1>
			<div>
				<x-form class="mx-3" method="POST" action="{{ route('customer.password.update') }}">
					<x-form-input type="hidden" name="token" :default="$token"/>
					<x-form-input type="email" name="email" label="Email" default="{{ $email ?? old('email') }}"
								  required autocomplete="email" autofocus/>
					<x-form-input type="password" name="password" label="Passwort" required/>
					<x-form-input type="password" name="password_confirmation" label="Passwort wiederholen" required/>
					<x-form-submit name="submit" class="btn btn-secondary">{{ __('Reset Password') }}</x-form-submit>
				</x-form>
			</div>
		</div>
	</div>
@endsection
