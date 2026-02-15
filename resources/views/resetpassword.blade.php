<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        /* SAME Background Gradient */
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #7dd3fc 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px; /* extra safety padding for mobile */
        }

        /* SMALL & CLEAN CARD */
        .login-card {
            width: 500px;
            background: rgba(255, 255, 255, 0.97);
            border-radius: 20px;

            padding: 40px 40px;   /* ⭐ More padding inside card */
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.28);
        }

        h4 {
            color: #1e3c72;
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 30px; /* ⭐ Better spacing under heading */
        }

        /* Inputs */
        .form-floating {
            margin-bottom: 25px; /* ⭐ More space between inputs */
        }

        .form-floating input {
            border: 2px solid #1e3c72;
            border-radius: 10px;
            height: 52px;
        }

        .form-control:focus {
            border-color: #2a5298 !important;
            box-shadow: 0 0 6px #2a5298 !important;
        }

        /* Button */
        .btn-custom {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
            padding: 12px;
            margin-top: 10px;    /* ⭐ Space above button */
        }

        .btn-custom:hover {
            background: linear-gradient(135deg, #2a5298, #1e3c72);
        }

        hr {
            margin: 25px 0;  /* ⭐ Nicer spacing around divider */
        }

        .text-center a {
            font-size: 16px;
            color: #1e3c72;
            font-weight: 600;
        }
    </style>
</head>

<body>

<div class="login-card">

    @if(Session::has('success'))
    <div class="alert alert-success py-2">{{ Session::get('success') }}</div>
    @endif

    @if(Session::has('error'))
    <div class="alert alert-danger py-2">{{ Session::get('error') }}</div>
    @endif

    <h4 class="text-center">Login</h4>

        

<form method="POST" action="{{ route('password.reset') }}">
@csrf

<input type="hidden" name="email" value="{{ $email }}">

<div class="form-floating position-relative mb-3">
    <input type="password" id="password"
           name="password" class="form-control"
           placeholder="New Password">
    <label>New Password</label>

    <span class="position-absolute top-50 end-0 translate-middle-y pe-3"
          style="cursor:pointer;"
          onclick="togglePassword('password','eye1')">
        <i class="bi bi-eye-slash" id="eye1"></i>
    </span>

    @error('password')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-floating position-relative mb-3">
    <input type="password"
           id="password_confirmation"
           name="password_confirmation"
           class="form-control"
           placeholder="Confirm Password">
    <label>Confirm Password</label>

    <span class="position-absolute top-50 end-0 translate-middle-y pe-3"
          style="cursor:pointer;"
          onclick="togglePassword('password_confirmation','eye2')">
        <i class="bi bi-eye-slash" id="eye2"></i>
    </span>
</div>
<button class="btn btn-custom w-100 mt-3">Reset Password</button>

</div>
</form>





 

</div>

</body>
</html>

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

