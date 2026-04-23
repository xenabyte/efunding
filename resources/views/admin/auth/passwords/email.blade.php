@extends('admin.layout.auth')

@section('title', 'Admin Password Recovery | ODA eFund')

@section('content')
<div class="p-lg-5 p-4">
    <div class="text-center">
        <div class="avatar-lg mx-auto">
            <div class="avatar-title bg-light text-primary display-5 rounded-circle">
                <i class="ri-shield-keyhole-line"></i>
            </div>
        </div>
        <h5 class="text-primary mt-4">Administrative Recovery</h5>
        <p class="text-muted">Enter your admin email to receive reset instructions.</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success border-0 rounded-pill text-center mb-4" role="alert">
            <strong>Success!</strong> {{ session('status') }}
        </div>
    @endif

    <div class="mt-4">
        <form method="POST" action="{{ url('/admin/password/email') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="form-label">Admin Email Address</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-light"><i class="ri-mail-send-line"></i></span>
                    <input type="email" class="form-control bg-light border-light @error('email') is-invalid @enderror" 
                           id="email" name="email" placeholder="Enter administrative email" 
                           value="{{ old('email') }}" required autofocus>
                </div>
                @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mt-4">
                <button class="btn btn-primary w-100 shadow-primary" type="submit">
                    Send Secure Reset Link
                </button>
            </div>
        </form>
    </div>

    <div class="mt-4 text-center">
        <p class="mb-0">Secure memory? 
            <a href="{{ url('/admin/login') }}" class="fw-semibold text-primary text-decoration-underline"> Back to Login </a> 
        </p>
    </div>
</div>

<div class="mt-5 text-center text-muted">
    <p class="mb-0">System Security Notice: All recovery attempts are logged by IP address.</p>
</div>
@endsection