@extends('layouts.public')

@section('main')
<div class="card">
    <div class="card-header">{{ __('Login') }}</div>

    <div class="card-body">
        <x-form method="POST" action="{{ route('login') }}">
            @csrf
            <x-input name="email" type="email" label="Email" required />
            <x-input name="password" type="password" label="Passwort" required />
            <x-checkbox name="remember" type="checkbox" label="Logindaten merken" required />
            <x-submit value="submit" />
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
