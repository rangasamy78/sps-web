@extends('layouts.admin.app')

@section('auth-content')
 {{-- content --}}
 <div class="card">
    <div class="card-body">
        {{-- Logo --}}
        @include('auth.partials.logo')
        {{-- Logo --}}
        <h4 class="mb-2">Welcome to ERP! 👋</h4>
        <p class="mb-3">Reset Password</p>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="emailOrUsername" class="form-label">{{ __('Email Address') }} <sup style="color: red;font-size:1rem;"><b>*</b></sup></label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter your email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Send Password Reset Link</button>
            </div>
        </form>
    </div>
    <p class="text-center">
        <span>New on our platform?</span>
        <a href="{{ route('login') }}">
            <span>Login</span>
        </a>
    </p>
</div>

{{-- content --}}
@endsection
