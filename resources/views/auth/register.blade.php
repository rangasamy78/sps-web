@extends('layouts.admin.app')

@section('auth-content')
    {{-- content --}}
    <div class="card">
        <div class="card-body">
            {{-- Logo --}}
            @include('auth.partials.logo')
            {{-- Logo --}}
            <p class="mb-3">Please register account first</p>
            <form id="Register" name="Register" method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="first_name" class="form-label">{{ __('First Name') }} <sup style="color: red;font-size:1rem;"><b>*</b></sup></label>
                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" placeholder="Enter your first name" autofocus>
                    @error('first_name')
                        <span class="invalid-feedback first_name_error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label">{{ __('Last Name') }} <sup style="color: red;font-size:1rem;"><b>*</b></sup></label>
                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" placeholder="Enter your last name">
                </div>

                <div class="mb-3">
                    <label for="emailOrUsername" class="form-label">{{ __('Email Address') }} <sup style="color: red;font-size:1rem;"><b>*</b></sup></label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter your email">

                    @error('email')
                        <span class="invalid-feedback email_error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="mb-3 form-password-toggle">
                    <label for="password" class="form-label">
                        {{ __('Password') }}
                        <sup style="color: red;font-size:1rem;"><b>*</b></sup>
                    </label>

                    <div class="input-group input-group-merge">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter your password">

                        <span class="cursor-pointer input-group-text" id="togglePassword">
                            <i class="bx bx-hide" id="toggleIcon"></i>
                        </span>
                        @error('password')
                            <span class="invalid-feedback password_error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-password-toggle">
                    <label for="password-confirm" class="form-label">
                        {{ __('Confirmation Password') }}
                        <sup style="color: red;font-size:1rem;"><b>*</b></sup>
                    </label>

                    <div class="input-group input-group-merge">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Enter your confirmation password">

                        <span class="cursor-pointer input-group-text" id="togglePasswordConfirm">
                            <i class="bx bx-hide" id="toggleIconConfirm"></i>
                        </span>
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-12 offset-md-2">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Register') }}
                        </button>
                        <button type="reset" class="btn btn-label-secondary">
                            <i class="bx bx-reset d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                          </button>
                    </div>
                </div>
            </form>
        </div> <!-- card-body -->

        <p class="text-center">
            <span>New on our platform?</span>
            {{-- <a href="{{ route('register') }}">
                <span>Create an account</span>
            </a> | --}}
            <a href="{{ route('login') }}">
                <span>Login</span>
            </a>
        </p>
    </div> <!-- card -->
    <script src="{{ asset('public/js/login.js') }}"></script>
@endsection
