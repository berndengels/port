@extends('layouts.main')

@section('main')
	<div class="row m-sm-2 m-md-5 align-self-center">
		<div class="m-auto col-sm-12 col-md-6 align-content-center">
			<h1 class="m-3 fs-3 dark-grey">{{ __('Admin Demo Login') }}</h1>
			<div>
				<x-form class="mx-3 frm-login" method="POST" action="{{ route('admin.login') }}">
					@if( isset($redirectTo) )
						<x-form-input type="hidden" name="redirectTo" :default="$redirectTo"/>
					@endif
					<div class="row">
						<div class="col-sm-6 col-lg-4">DEMO User:</div>
						<div class="col-sm-6 col-lg-8">admin@test.loc</div>
					</div>
					<div class="row mb-3">
						<div class="col-sm-6 col-lg-4">DEMO Passwort:</div>
						<div class="col-sm-6  col-lg-8">password</div>
					</div>
					<x-form-input name="email" type="email" label="Email" required/>
					<x-form-input name="password" type="password" label="Passwort" required/>
					<div class="mt-3">
						<x-form-checkbox name="remember" type="checkbox" label="Logindaten merken">
							Logindaten merken
						</x-form-checkbox>
					</div>
					<x-form-submit value="submit" class="btn btn-secondary mt-3" icon="fas fa-sign-in-alt">Login
					</x-form-submit>
					<div class="mt-3">
						@if (Route::has('customer.password.request'))
							<a class="link-secondary" href="{{ route('admin.password.request') }}">
								{{ __('Passwort vergessen?') }}
							</a>
						@endif
					</div>
				</x-form>
			</div>
		</div>
	</div>
@endsection
