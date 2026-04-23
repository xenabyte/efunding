@extends('user.layout.auth')

@section('title', 'Join ODA | Member Registration')

@section('content')
<div class="p-lg-5 p-4">
    <div class="text-center">
        <h5 class="text-primary">Create Your Account</h5>
        <p class="text-muted">Get your ODA Member ID and start contributing.</p>
    </div>

    <div class="mt-4">
        <form method="POST" action="{{ url('/user/register') }}" class="needs-validation">
            @csrf

            <div class="mb-3">
                <label for="username" class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       name="name" id="username" placeholder="Enter full name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="useremail" class="form-label">Email Address <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       name="email" id="useremail" placeholder="Enter email address" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="member_type" class="form-label">Member Category <span class="text-danger">*</span></label>
                        <select class="form-select @error('member_type') is-invalid @enderror" name="member_type" id="member_type" required>
                            <option value="" selected disabled>Select Type</option>
                            <option value="resident" {{ old('member_type') == 'resident' ? 'selected' : '' }}>Resident Member</option>
                            <option value="diaspora" {{ old('member_type') == 'diaspora' ? 'selected' : '' }}>Diaspora Member</option>
                        </select>
                        @error('member_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="e.g. +234..." value="{{ old('phone') }}">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="password-input">Password</label>
                <div class="position-relative auth-pass-inputgroup">
                    <input type="password" name="password" class="form-control pe-5 password-input @error('password') is-invalid @enderror" 
                           placeholder="Enter password" id="password-input" required>
                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button"><i class="ri-eye-fill align-middle"></i></button>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="confirm-password">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" 
                       placeholder="Confirm password" id="confirm-password" required>
            </div>

            <div class="mb-4">
                <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to the ODA <a href="#" class="text-primary text-decoration-underline fst-normal fw-medium">Terms of Use</a></p>
            </div>

            <div class="mt-4">
                <button class="btn btn-success w-100" type="submit">Sign Up</button>
            </div>
        </form>
    </div>

    <div class="mt-4 text-center">
        <p class="mb-0">Already have an account? <a href="{{ url('/user/login') }}" class="fw-semibold text-primary text-decoration-underline"> Signin </a> </p>
    </div>
</div>
@endsection