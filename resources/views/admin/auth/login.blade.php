@extends('admin.layout.auth')

@section('title', 'Admin Login | ODA eFund')

@section('content')
<div class="p-lg-5 p-4">
    <div>
        <h5 class="text-primary">Administrative Access</h5>
        <p class="text-muted">Sign in to manage ODA Community Funds.</p>
    </div>

    <div class="mt-4">
        <form method="POST" action="{{ url('/admin/login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" placeholder="Enter admin email" 
                       value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <div class="float-end">
                    <a href="{{ url('/admin/password/reset') }}" class="text-muted">Forgot password?</a>
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
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="auth-remember-check">
                <label class="form-check-label" for="auth-remember-check">Remember me</label>
            </div>

            <div class="mt-4">
                <button class="btn btn-success w-100" type="submit">Sign In</button>
            </div>

            <div class="mt-4 text-center">
                <div class="signin-other-title">
                    <h5 class="fs-13 mb-4 title">Community Links</h5>
                </div>
                <div>
                    <a href="{{ url('/user/login') }}" class="btn btn-soft-info btn-sm">
                        <i class="ri-user-line align-bottom"></i> Member Portal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection