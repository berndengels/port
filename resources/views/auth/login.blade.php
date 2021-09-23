@extends('layouts.main')

@section('main')
<div class="main-cards">
    <h3 class="">{{ __('Login') }}</h3>

    <div class="">
        <x-form method="POST" action="{{ route('login') }}">
            @csrf
            <x-form-input name="email" type="email" label="Email" required />
            <x-form-input name="password" type="password" label="Passwort" required />
            <div class="mt-3">
                <x-form-checkbox name="remember" type="checkbox" label="Logindaten merken">
                    Logindaten merken
                </x-form-checkbox>
            </div>
            <x-form-submit value="submit" class="btn btn-save mt-3" icon="fas fa-sign-in-alt">Login</x-form-submit>
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
