@extends('layouts.main')

@section('main')
	<div class="w-full">
		<h1 class="sm:mt-5 m-3 text-4xl">{{ __('Registrierung') }}</h1>
		<div class="flex w-full justify-center">
			<x-form class="w-full mx-3 md:w-1/2" method="POST" action="{{ route('register') }}">
				<x-form-input name="name" label="Name" required/>
				<x-form-input name="email" type="email" label="Email" required/>
				<x-form-input name="password" type="password" label="Passwort" required/>
				<x-form-input name="password_confirmation" type="password" label="Passwort wiederholen" required/>

				<x-form-submit class="btn-sm btn-primary" icon="fas fa-sign-in-alt">
					Register
				</x-form-submit>
			</x-form>
		</div>
	</div>
@endsection
