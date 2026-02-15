@extends('layouts.app')

@section('title', 'Change Password')

@section('content')

<style>
    .setting-card {
        width: 100%;
        max-width: 650px;
        background: #ffffff;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: 0.3s ease-in-out;
    }

    .setting-card:hover {
        transform: scale(1.01);
    }

    .title {
        font-size: 28px;
        font-weight: 700;
        color: #333;
        margin-bottom: 25px;
        text-align: center;
    }

    .form-label {
        font-weight: 600;
    }

    .btn-save {
        padding: 12px 40px;
        font-size: 16px;
        font-weight: 600;
    }
</style>

<div class="d-flex justify-content-center mt-5 py-5">
    <div class="setting-card">

        <h2 class="title">Change Password</h2>

        <form action="{{ route('admin.setting.update') }}" method="POST">
            @csrf

         <!-- Old Password -->
<div class="mb-4">
    <label class="form-label">Old Password <span class="text-danger">*</span></label>

    <div class="input-group">
        <input type="password" 
               name="old_password" 
               id="old_password"
               class="form-control form-control-lg @error('old_password') is-invalid @enderror"
               placeholder="Enter old password">

        <span class="input-group-text" 
              style="cursor:pointer;"
              onclick="togglePassword('old_password', this)">
            <i class="bi bi-eye-slash"></i>
        </span>
    </div>

    @error('old_password')
        <small class="text-danger fw-bold">{{ $message }}</small>
    @enderror
</div>


<!-- New Password -->
<div class="mb-4">
    <label class="form-label">New Password <span class="text-danger">*</span></label>

    <div class="input-group">
        <input type="password" 
               name="new_password" 
               id="new_password"
               class="form-control form-control-lg @error('new_password') is-invalid @enderror"
               placeholder="Enter new password">

        <span class="input-group-text" 
              style="cursor:pointer;"
              onclick="togglePassword('new_password', this)">
            <i class="bi bi-eye-slash"></i>
        </span>
    </div>

    @error('new_password')
        <small class="text-danger fw-bold">{{ $message }}</small>
    @enderror
</div>


<!-- Confirm Password -->
<div class="mb-4">
    <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>

    <div class="input-group">
        <input type="password" 
               name="confirm_password" 
               id="confirm_password"
               class="form-control form-control-lg @error('confirm_password') is-invalid @enderror"
               placeholder="Confirm new password">

        <span class="input-group-text" 
              style="cursor:pointer;"
              onclick="togglePassword('confirm_password', this)">
            <i class="bi bi-eye-slash"></i>
        </span>
    </div>

    @error('confirm_password')
        <small class="text-danger fw-bold">{{ $message }}</small>
    @enderror
</div>


            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-save">
                    Save Changes
                </button>
            </div>

        </form>

    </div>
</div>


<script>
function togglePassword(fieldId, icon) {
    const input = document.getElementById(fieldId);
    const type = input.type === 'password' ? 'text' : 'password';
    input.type = type;

    icon.innerHTML = type === 'password'
        ? '<i class="bi bi-eye-slash"></i>'
        : '<i class="bi bi-eye"></i>';
}
</script>

@endsection
