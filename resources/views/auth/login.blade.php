@extends('layouts.public')

@section('main')
<div class="main-cards">
    <div class="main-header">{{ __('Login') }}</div>

    <div class="card">
        <x-form method="POST" action="{{ route('login') }}">
            @csrf
            <x-form-input name="email" type="email" label="Email" required />
            <x-form-input name="password" type="password" label="Passwort" required />
            <x-form-checkbox name="remember" type="checkbox" label="Logindaten merken" required />
            <x-form-submit value="submit" />
            <div>
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </x-form>
    </div>
</div>
@endsection
