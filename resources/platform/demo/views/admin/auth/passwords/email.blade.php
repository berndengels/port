@extends('layouts.main')

@section('main')
	<div class="w-full">
		<h1 class="sm:mt-5 m-3 text-4xl">{{ __('auth.Reset Password') }}</h1>
		<div class="flex w-full justify-center">
			<x-form class="w-full mx-3 md:w-1/2" method="POST" action="{{ route('admin.password.email') }}">
				<x-form-input type="email" name="email" label="Email" required/>
				<x-form-submit name="submit">{{ __('Sende Passwort Reset-Link') }}</x-form-submit>
			</x-form>
		</div>
	</div>
@endsection
