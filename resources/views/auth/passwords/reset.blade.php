@extends('layouts.main')

@section('main')
<div class="w-full">
    <h1 class="sm:mt-5 m-3 text-4xl">{{ __('Login') }}</h1>
    <div class="flex w-full justify-center">
        <x-form class="w-full mx-3 md:w-1/2" method="POST" action="{{ route('password.update') }}">
            <x-form-input type="hidden" name="token" :default="$token" />
            <x-form-input type="email" name="email" label="Email" default="{{ $email ?? old('email') }}" required autocomplete="email" autofocus />
            <x-form-input type="password" name="password" label="Passwort" required />
            <x-form-input type="password" name="password_confirmation" label="Passwort wiederholen" required />
            <x-form-submit name="submit">{{ __('Reset Password') }}</x-form-submit>
        </x-form>
    </div>
</div>
@endsection
