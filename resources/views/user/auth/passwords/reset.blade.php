@extends('user.layout.auth')

@section('title', 'Create New Password | ODA eFund')

@section('content')
<div class="p-lg-5 p-4">
    <div class="text-center">
        <lord-icon src="https://cdn.lordicon.com/vjbcampd.json" trigger="loop" 
            colors="primary:#0ab39c" style="width:72px;height:72px">
        </lord-icon>
        
        <h5 class="text-primary mt-3">Reset Your Password</h5>
        <p class="text-muted">Ensure your new password is strong and secure.</p>
    </div>

    <div class="mt-4">
        <form method="POST" action="{{ url('/user/password/reset') }}">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="useremail" class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ri-mail-line"></i></span>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="useremail" name="email" value="{{ $email ?? old('email') }}" 
                           placeholder="Enter your email" required readonly>
                </div>
                @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="password-input">New Password</label>
                <div class="position-relative auth-pass-inputgroup">
                    <input type="password" name="password" 
                           class="form-control pe-5 password-input @error('password') is-invalid @enderror" 
                           placeholder="Enter new password" id="password-input" required>
                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" 
                            type="button">
                        <i class="ri-eye-fill align-middle"></i>
                    </button>
                </div>
                @error('password')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="confirm-password">Confirm New Password</label>
                <div class="position-relative auth-pass-inputgroup">
                    <input type="password" name="password_confirmation" class="form-control pe-5" 
                           placeholder="Repeat your password" id="confirm-password" required>
                </div>
            </div>

            <div id="password-contain" class="p-3 bg-light mb-3 rounded">
                <h5 class="fs-13">Password requirements:</h5>
                <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8 characters</b></p>
                <p id="pass-lower" class="invalid fs-12 mb-2">At least <b>one lowercase</b> letter</p>
                <p id="pass-upper" class="invalid fs-12 mb-2">At least <b>one uppercase</b> letter</p>
                <p id="pass-number" class="invalid fs-12 mb-0">At least <b>one number</b></p>
            </div>

            <div class="mt-4">
                <button class="btn btn-success w-100" type="submit">
                    <i class="ri-refresh-line align-bottom me-1"></i> Update Password
                </button>
            </div>
        </form>
    </div>

    <div class="mt-5 text-center">
        <p class="mb-0 text-muted">Remembered your password? 
            <a href="{{ url('/user/login') }}" class="fw-semibold text-primary text-decoration-underline"> Back to Login </a> 
        </p>
    </div>
</div>
@endsection