@extends('admin.layout.auth')

@section('title', 'Admin: Set New Password | ODA eFund')

@section('content')
<div class="p-lg-5 p-4">
    <div class="text-center">
        <div class="mb-4">
            <lord-icon src="https://cdn.lordicon.com/hzomhqxz.json" trigger="loop" 
                colors="primary:#405189,secondary:#0ab39c" style="width:120px;height:120px">
            </lord-icon>
        </div>
        <h5 class="text-primary">Update Admin Credentials</h5>
        <p class="text-muted">Please set a high-complexity password to secure the Administrative Portal.</p>
    </div>

    <div class="mt-4">
        <form method="POST" action="{{ url('/admin/password/reset') }}">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="email" class="form-label">Administrative Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ri-admin-line"></i></span>
                    <input type="email" class="form-control bg-light @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ $email ?? old('email') }}" 
                           placeholder="Enter admin email" required readonly>
                </div>
                @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="password-input">New Admin Password</label>
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
                <label class="form-label" for="confirm-password">Confirm Admin Password</label>
                <div class="position-relative auth-pass-inputgroup">
                    <input type="password" name="password_confirmation" class="form-control pe-5" 
                           placeholder="Repeat password" id="confirm-password" required>
                </div>
            </div>

            <div id="password-contain" class="p-3 bg-light mb-4 rounded border">
                <h5 class="fs-13 text-dark"><i class="ri-shield-check-line me-1 text-success"></i> Security Standards:</h5>
                <ul class="list-unstyled mb-0">
                    <li class="fs-12 mb-1"><i class="ri-checkbox-blank-circle-fill me-2 text-primary"></i>Minimum 10 characters</li>
                    <li class="fs-12 mb-1"><i class="ri-checkbox-blank-circle-fill me-2 text-primary"></i>Mix of Uppercase & Numbers</li>
                    <li class="fs-12"><i class="ri-checkbox-blank-circle-fill me-2 text-primary"></i>Special character recommended</li>
                </ul>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary w-100 shadow" type="submit">
                    <i class="ri-lock-password-line align-bottom me-1"></i> Update Admin Password
                </button>
            </div>
        </form>
    </div>

    <div class="mt-4 text-center">
        <p class="mb-0 text-muted">Return to <a href="{{ url('/admin/login') }}" class="fw-semibold text-primary text-decoration-underline">Secure Login</a></p>
    </div>
</div>
@endsection