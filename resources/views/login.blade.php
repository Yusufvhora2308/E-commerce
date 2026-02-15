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
        .input-group-text {
    border: 2px solid #1e3c72;
    background: #fff;
}
.input-group .form-floating > .form-control {
    height: 53px;
}

.input-group .form-floating {
    flex: 1;
}

.input-group-text {
    height: 58px;
    display: flex;
    align-items: center;
}

    </style>
</head>

<body>

<div class="login-card">

    <h4 class="text-center">Login</h4>

    <form action="{{ route('account.authenicate') }}" method="POST">
        @csrf

      <div class="form-floating">
    <input type="text"
           class="form-control"
           name="email"
           placeholder="Email"
            >
    <label>Email</label>

    @error('email')
        <small class="text-danger d-block mt-1 fw-bold">
            {{ $message }}
        </small>
    @enderror
</div>

      <div class="mb-3">
    <div class="input-group">

        <div class="form-floating">
            <input type="password"
                   id="password"
                   class="form-control"
                   name="password"
                   placeholder="Password">
            <label>Password</label>
        </div>

        <!-- Eye Icon Box -->
        <span class="input-group-text"
              onclick="togglePassword()"
              style="cursor:pointer;">
            <i id="eyeIcon" class="bi bi-eye-slash"></i>
        </span>

    </div>

    <!-- Validation -->
    @error('password')
        <small class="text-danger d-block mt-1 fw-bold">
            {{ $message }}
        </small>
    @enderror
</div>




<div class="text-end mb-2">
    <a href="{{ route('password.forgot') }}">Forgot Password?</a>
</div>

        <button class="btn btn-custom w-100" type="submit">Login</button>

        
    </form>

    <hr>

    <div class="text-center">
        <a href="{{ route('account.register') }}">Create new account</a>
    </div>

</div>

</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function togglePassword() {
    const field = document.getElementById("password");
    const eye = document.getElementById("eyeIcon");

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



    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            confirmButtonColor: '#2a5298'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
            confirmButtonColor: '#d33'
        });
    @endif

</script>
