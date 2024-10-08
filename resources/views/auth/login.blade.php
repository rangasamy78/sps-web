@extends('layouts.admin.app')

@section('auth-content')
{{-- content --}}
<div class="card">
    <div class="card-body">
        {{-- Logo --}}
        @include('auth.partials.logo')
        {{-- Logo --}}
        <h4 class="mb-2">Welcome to ERP! 👋</h4>
        <p class="mb-3">Please sign-in to your account first</p>
        <form id="Login" name="Login" class="mb-3" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email Address') }} <sup style="color: red;font-size:1rem;"><b>*</b></sup></label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter your email" autofocus>
                @error('email')
                <span class="invalid-feedback email_error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">{{ __('Password') }} <sup style="color: red;font-size:1rem;"><b>*</b></sup></label>
                    <a href="{{ route('password.request') }}">
                        <small>Forgot Password?</small>
                    </a>
                </div>
                <div class="input-group input-group-merge">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter password">
                    <span class="cursor-pointer input-group-text"><i class="bx bx-hide"></i></span>

                    @error('password')
                    <span class="invalid-feedback password_error" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} value="1">
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
            <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
            </div>
        </form>

    </div>
    <p class="text-center">
        <span>New on our platform?</span>
        <a href="{{ route('register') }}">
            <span>Create an account</span>
        </a>
    </p>
</div>
<script src="{{ asset('public/js/login.js') }}"></script>
@endsection
