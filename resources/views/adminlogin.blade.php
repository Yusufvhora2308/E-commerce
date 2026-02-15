<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Admin</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #7dd3fc 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            width: 520px !important;
            height: 450px;
            background: rgba(255, 255, 255, 0.96);
            border-radius: 20px !important;
            padding: 50px 50px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.30);
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .card-body {
            width: 100%;
            padding: 0 !important;
        }

        h4 {
            color: #1e3c72;
            font-weight: 700;
            margin-bottom: 35px !important;
        }

        .form-floating {
            margin-bottom: 25px !important;
        }

        .form-control {
            border: 2px solid #1e3c72;
            border-radius: 12px;
            height: 55px;
        }

        .form-control:focus {
            border-color: #2a5298 !important;
            box-shadow: 0 0 6px #2a5298 !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            border: none;
            font-weight: 600;
            border-radius: 12px;
            padding: 14px;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2a5298, #1e3c72);
        }

        .input-group-text {
    border: 2px solid #1e3c72;
    background: #fff;
    height: 58px;
    display: flex;
    align-items: center;
}

    </style>

</head>
<body>

<div class="card">
    <div class="card-body">

      
        <h4 class="text-center">Admin Login Here</h4>

        <form action="{{ route('admin.authenicate') }}" method="POST">
            @csrf

            <div class="form-floating">
                <input type="text" 
                    class="form-control @error('email') is-invalid @enderror"
                    name="email" 
                    id="email" 
                    placeholder="name@example.com"
                    value="{{ old('email') }}">
                <label for="email">Email</label>
                @error('email') <p class="invalid-feedback fw-bold">{{ $message }}</p> @enderror
            </div>

      <div class="mb-3">
    <div class="input-group">

        <div class="form-floating">
            <input type="password" 
                class="form-control @error('password') is-invalid @enderror"
                name="password" 
                id="password"
                placeholder="Password">
            <label for="password">Password</label>
        </div>

        <!-- Eye Icon Box -->
        <span class="input-group-text" 
              id="togglePassword" 
              style="cursor:pointer;">
            <i class="bi bi-eye-slash"></i>
        </span>
    </div>
     @error('password')
        <p` class="text-danger  fw-bold">
            {{ $message }}
</p>
    @enderror

</div>


            <button class="btn btn-primary w-100 fw-bold" type="submit">
                Log in now
            </button>
        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Password toggle JS -->
<script>
   const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // Toggle icon: show eye when password is visible, eye-slash when hidden
        this.innerHTML = type === 'password' ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
    });


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

</body>
</html>
