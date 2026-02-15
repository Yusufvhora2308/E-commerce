@extends('layouts.user')

@section('title', 'Change Password')

@section('content')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">

                    <h3 class="fw-bold text-center mb-4">Change Password</h3>

                    <form action="{{ route('profile.updatePassword') }}" method="POST">
                        @csrf

                        {{-- OLD PASSWORD --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Old Password</label>

                            <div class="input-group">
                                <input type="password" 
                                       id="old_password"
                                       name="old_password"
                                       class="form-control @error('old_password') is-invalid @enderror"
                                       placeholder="Enter old password">

                                <span class="input-group-text"
                                      onclick="togglePassword('old_password','eye1')"
                                      style="cursor:pointer;">
                                    <i id="eye1" class="bi bi-eye-slash"></i>
                                </span>
                            </div>

                            @error('old_password')
                                <div class="invalid-feedback d-block fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NEW PASSWORD --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">New Password</label>

                            <div class="input-group">
                                <input type="password" 
                                       id="new_password"
                                       name="new_password"
                                       class="form-control @error('new_password') is-invalid @enderror"
                                       placeholder="Enter new password">

                                <span class="input-group-text"
                                      onclick="togglePassword('new_password','eye2')"
                                      style="cursor:pointer;">
                                    <i id="eye2" class="bi bi-eye-slash"></i>
                                </span>
                            </div>

                            @error('new_password')
                                <div class="invalid-feedback d-block fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- CONFIRM PASSWORD --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirm Password</label>

                            <div class="input-group">
                                <input type="password" 
                                       id="confirm_password"
                                       name="confirm_password"
                                       class="form-control @error('confirm_password') is-invalid @enderror"
                                       placeholder="Confirm new password">

                                <span class="input-group-text"
                                      onclick="togglePassword('confirm_password','eye3')"
                                      style="cursor:pointer;">
                                    <i id="eye3" class="bi bi-eye-slash"></i>
                                </span>
                            </div>

                            @error('confirm_password')
                                <div class="invalid-feedback d-block fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- BUTTON --}}
                        <button class="btn btn-dark w-100 py-2 fw-bold">
                            Update Password
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>


<script>
function togglePassword(fieldId, eyeId) {
    const field = document.getElementById(fieldId);
    const eye = document.getElementById(eyeId);

    if (field.type === "password") {
        field.type = "text";
        eye.classList.remove("bi-eye-slash");
        eye.classList.add("bi-eye");
    } else {
        field.type = "password";
        eye.classList.remove("bi-eye");
        eye.classList.add("bi-eye-slash");
    }
}
</script>
@endsection






