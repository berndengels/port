@extends('layouts.main')

@section('main')
<div class="w-full">
    <h1 class="sm:mt-5 m-3 text-4xl">{{ __('Login') }}</h1>
    <div class="flex w-full justify-center">
        <x-form class="w-full mx-3 md:w-1/2" method="POST" action="{{ route('login') }}">
            <x-form-input name="email" type="email" label="Email" required />
            <x-form-input name="password" type="password" label="Passwort" required />
            <div class="mt-3">
                <x-form-checkbox name="remember" type="checkbox" label="Logindaten merken">
                    Logindaten merken
                </x-form-checkbox>
            </div>
            <x-form-submit value="submit" class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-sign-in-alt">Login</x-form-submit>
            <div class="mt-3">
                @if (Route::has('password.request'))
                    <a class="btn-link blue" href="{{ route('password.request') }}">
                        {{ __('Passwort vergessen?') }}
                    </a>
                @endif
            </div>
        </x-form>
    </div>
</div>
@endsection
