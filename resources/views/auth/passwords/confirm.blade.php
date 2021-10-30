@extends('layouts.main')

@section('main')
<div class="w-full">
    <h1 class="sm:mt-5 m-3 text-4xl">{{ __('Please confirm your password before continuing.') }}</h1>
    <div class="flex w-full justify-center">
    <x-form class="w-full mx-3 md:w-1/2" method="POST" action="{{ route('password.confirm') }}">
        <x-form-input type="password" name="password" label="Passwort" />
        <x-form-submit name="submit">{{ __('Confirm Password') }}</x-form-submit>
        @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Passwort vergessen?') }}
            </a>
        @endif
    </x-form>
</div>
@endsection
