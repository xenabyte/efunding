@extends('user.layout.auth')

@section('title', 'Member Login | ODA eFund')

@section('content')
<div class="p-lg-5 p-4">
    <div class="text-center">
        <h5 class="text-primary">Welcome Back!</h5>
        <p class="text-muted">Sign in to your ODA Member Portal</p>
    </div>

    <div class="mt-4">
        <form method="POST" action="{{ url('/user/login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ri-mail-line"></i></span>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" placeholder="Enter your email" 
                           value="{{ old('email') }}" required autofocus>
                </div>
                @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <div class="float-end">
                    <a href="{{ url('/user/password/reset') }}" class="text-muted">Forgot password?</a>
                </div>
                <label class="form-label" for="password-input">Password</label>
                <div class="position-relative auth-pass-inputgroup mb-3">
                    <input type="password" name="password" 
                           class="form-control pe-5 password-input @error('password') is-invalid @enderror" 
                           placeholder="Enter password" id="password-input" required>
                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" 
                            type="button" id="password-addon">
                        <i class="ri-eye-fill align-middle"></i>
                    </button>
                </div>
                @error('password')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="auth-remember-check">
                <label class="form-check-label" for="auth-remember-check">Remember me</label>
            </div>

            <div class="mt-4">
                <button class="btn btn-success w-100" type="submit">
                    Log In
                </button>
            </div>

            <div class="mt-4 text-center">
                <p class="mb-0">Not a registered member? 
                    <a href="{{ url('/user/register') }}" class="fw-semibold text-primary text-decoration-underline"> Join ODA </a> 
                </p>
            </div>
        </form>
    </div>

    <div class="mt-5 text-center">
        <p class="mb-0 text-muted">Are you an Association Executive?</p>
        <a href="{{ url('/admin/login') }}" class="btn btn-link text-info fw-bold">
            <i class="ri-shield-user-line me-1"></i> Go to Admin Portal
        </a>
    </div>
</div>
@endsection