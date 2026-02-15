<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    <style>
        /* Background Gradient */
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #7dd3fc 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Card Design */
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        }

        h4 {
            color: #1e3c72;
            font-weight: 700;
        }

        /* Input Styling */
        .form-floating input {
            border: 2px solid #1e3c72;
            border-radius: 10px;
        }

        .form-floating label {
            color: #1e3c72;
            font-weight: 600;
        }

        .form-control:focus {
            border-color: #2a5298;
            box-shadow: 0 0 5px #2a5298;
        }

        /* Button Styling */
        .btn-custom {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
            padding: 12px;
        }

        .btn-custom:hover {
            background: linear-gradient(135deg, #2a5298, #1e3c72);
            color: #fff;
        }

        a {
            color: #1e3c72;
            text-decoration: none;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }

    </style>
</head>

<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="register-card">

                <h4 class="text-center mb-4">Register Here</h4>

                <form action="{{ route('account.proccessregister') }}" method="POST">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror">
                        <label>Name</label>
                        @error('name') <p class="invalid-feedback">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror">
                        <label>Email</label>
                        @error('email') <p class="invalid-feedback">{{ $message }}</p> @enderror
                    </div>

        <div class="mb-3">
    <div class="input-group">
        <div class="form-floating">
            <input type="password" id="password" name="password"
                   class="form-control">
            <label>Password</label>
        </div>

        <!-- Eye Icon Box -->
        <span class="input-group-text" onclick="togglePassword('password','eye1')" style="cursor:pointer;">
            <i id="eye1" class="bi bi-eye-slash fw-bold fs-5"></i>
        </span>
    </div>

    @error('password') <p class="text-danger">{{ $message }}</p> @enderror
</div>


<div class="mb-3">
    <div class="input-group">
        <div class="form-floating">
            <input type="password" id="password_confirmation" name="password_confirmation"
                   class="form-control @error('password_confirmation') is-invalid @enderror">
            <label>Confirm Password</label>
        </div>

        <!-- Eye Icon Box -->
        <span class="input-group-text" onclick="togglePassword('password_confirmation','eye2')" style="cursor:pointer;">
            <i id="eye2" class="bi bi-eye-slash fw-bold fs-5"></i>
        </span>
    </div>

    @error('password_confirmation') 
        <p class="invalid-feedback">{{ $message }}</p> 
    @enderror
</div>



                    <button class="btn btn-custom w-100" type="submit">Register Now</button>

                </form>

                <hr class="my-4">

                <p class="text-center">
                    Already have an account?
                    <a href="{{ route('account.login') }}">Login</a>
                </p>

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


</body>
</html>
