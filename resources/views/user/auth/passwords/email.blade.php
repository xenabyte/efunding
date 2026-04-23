@extends('user.layout.auth')

@section('title', 'Reset Password | ODA Member Portal')

@section('content')
<div class="p-lg-5 p-4">
    <div class="text-center">
        <lord-icon src="https://cdn.lordicon.com/rhbddymv.json" trigger="loop" 
            colors="primary:#0ab39c" style="width:72px;height:72px">
        </lord-icon>
        
        <h5 class="text-primary mt-3">Forgot Password?</h5>
        <p class="text-muted">Reset your ODA Member Portal password</p>
    </div>

    @if (session('status'))
        <div class="alert alert-borderless alert-success text-center mb-2 mx-2" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="mt-4">
        <div class="alert alert-warning text-center mb-4" role="alert">
            Enter your email and instructions will be sent to you!
        </div>

        <form method="POST" action="{{ url('/user/password/email') }}">
            @csrf

            <div class="mb-4">
                <label for="useremail" class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ri-mail-line"></i></span>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="useremail" name="email" placeholder="Enter your registered email" 
                           required autofocus>
                </div>
                @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="text-center mt-4">
                <button class="btn btn-success w-100" type="submit">
                    Send Reset Link
                </button>
            </div>
        </form>
    </div>

    <div class="mt-5 text-center">
        <p class="mb-0">Wait, I remember my password... 
            <a href="{{ url('/user/login') }}" class="fw-semibold text-primary text-decoration-underline"> Click here </a> 
        </p>
    </div>
</div>
@endsection