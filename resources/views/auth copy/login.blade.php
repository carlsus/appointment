@extends('layouts.login')
@section('title', 'Log In')
@section('content')
<div class="login-box">
    <div class="login-logo">
    <a href="{{ url('/home')}}"><b>Appointment</b> System</a>
    </div>

    <div class="card">
    <div class="card-body login-card-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
        @csrf
        <div class="form-group">
            <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
            <div class="">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus required>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>

            <div class="">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row">
        <div class="col-8">
        <div class="icheck-primary">
        <input type="checkbox" id="remember">
        <label class="form-check-label" for="remember">
            {{ __('Remember Me') }}
        </label>
        </div>
        </div>

        <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">
                {{ __('Login') }}
            </button>
        </div>

        </div>
    </form>

    <p class="mb-0">
        @if (Route::has('register'))
        <a class="btn btn-link" href="{{ route('registration.index') }}">
            {{ __('Register') }}
        </a>
    @endif
    </p>
    </div>

    </div>
    </div>



@endsection
