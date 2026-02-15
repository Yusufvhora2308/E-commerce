<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    
    <link rel="stylesheet" 
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>

        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        /* ==================== NAVBAR ==================== */

        .customer-navbar {
            padding: 18px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
            border-bottom: 1px solid #e6e6e6;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo img {
            height: 60px;
        }

        .customer-menu a {
            margin: 0 20px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            color: #111;
            letter-spacing: 0.5px;
            transition: 0.3s ease;
        }

        .customer-menu a:hover {
            color: #8c8c8c;
        }

        .customer-icons i {
            margin: 0 14px;
            font-size: 20px;
            cursor: pointer;
            color: #000;
            transition: 0.3s ease;
        }

        .customer-icons i:hover {
            color: #666;
        }

        /* CART BADGE */
        .cart-badge {
            background: #c5a15e;
            color: white;
            font-size: 12px;
            padding: 2px 6px;
            border-radius: 50%;
            position: absolute;
            top: -6px;
            right: -10px;
        }

        /* DROPDOWN MENU */
        .dropdown-menu {
            border-radius: 10px;
            padding: 10px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .dropdown-menu .dropdown-header {
            font-size: 16px;
            color: #444;
        }

        .dropdown-item i {
            width: 22px;
        }

        .dropdown-item:hover {
            background: #f2f2f2;
        }
        .logo{
            width: ;
        }

    </style>
</head>

<body>

{{-- ==================== NAVBAR ==================== --}}
<div class="customer-navbar">

    {{-- LOGO --}}
    <div class="logo ">
        <a href="{{ route('account.dashboard') }}"><img src="/IMAGES/E COMMERCE LOGO.jpg" alt="Logo"></a>
    </div>

   {{-- CENTER MENU --}}
<div class="customer-menu d-flex gap-4">
    <a href="{{ route('account.dashboard') }}" 
       class="d-flex align-items-center gap-1 {{ Route::currentRouteName() == 'account.dashboard' ? 'text-primary' : '' }}">
        <i class="bi bi-house-door"></i> HOME
    </a>

    <a href="{{ route('shop') }}" 
       class="d-flex align-items-center gap-1 {{ Route::currentRouteName() == 'shop' ? 'text-primary' : '' }}">
        <i class="bi bi-shop"></i> SHOP
    </a>

    <a href="{{ route('cart') }}" 
       class="d-flex align-items-center gap-1 {{ Route::currentRouteName() == 'cart' ? 'text-primary' : '' }}">
        <i class="bi bi-cart"></i> CART
    </a>

    <a href="{{ route('Aboutus') }}" 
       class="d-flex align-items-center gap-1 {{ Route::currentRouteName() == 'Aboutus' ? 'text-primary' : '' }}">
        <i class="bi bi-info-circle"></i> ABOUT
    </a>

    <a href="{{ route('Contact') }}" 
       class="d-flex align-items-center gap-1 {{ Route::currentRouteName() == 'Contact' ? 'text-primary' : '' }}">
        <i class="bi bi-telephone"></i> CONTACT
    </a>
</div>



    {{-- RIGHT ICONS --}}
    <div class="customer-icons d-flex align-items-center">

      

        {{-- USER DROPDOWN --}}
        <div class="dropdown">
            <i class="fa-regular fa-user" data-bs-toggle="dropdown"></i>

            <ul class="dropdown-menu dropdown-menu-end">

                <li class="dropdown-header fw-bold text-center">
                    {{ Auth::user()->name }}
                </li>

                <li><hr class="dropdown-divider"></li>

                <li>
                    <a class="dropdown-item" href="{{ route('Profile') }}">
                        <i class="fa-regular fa-user"></i> Profile
                    </a>
                </li>

                <li>
                    <a class="dropdown-item" href="{{ route('profile.password') }}">
                        <i class="fa-solid fa-lock"></i> Change Password
                    </a>
                </li>

                 <li>
                    <a class="dropdown-item" href="{{ route('wishlist.index') }}">
                         <i class="bi bi-heart"></i> Wishlist
                    </a>
                </li>

                  <li>
                    <a class="dropdown-item" href="{{ route('userorder.detail') }}">
                         <i class="fa-solid fa-bag-shopping"></i> Your Orders
                    </a>
                </li>

                <li>
                    <a class="dropdown-item text-danger" href="{{ route('account.logout') }}">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

      

        {{-- CART --}}
        <div style="position: relative;">
            <a href="{{ route('cart') }}"><i class="fa fa-shopping-bag"></i></a>
            
        </div>

    </div>
</div>

{{-- ==================== CONTENT ==================== --}}
<div class="container py-4">
    @yield('content')
</div>



<footer class="bg-white border-top mt-5 pt-5 w-100">
    <!-- Full-width container -->
    <div class="container-fluid px-5">

        <div class="row">

            <!-- Column 1: Logo & Contact -->
            <div class="col-md-3 mb-4">
                <img src="/IMAGES/E COMMERCE LOGO.jpg" alt="Logo" class="img-fluid mb-3" style="max-width:150px;">
                <p class="mb-1">123 Beach Avenue, Surfside City, CA 00000</p>
                <p class="mb-1">vhoray8@gmail.com</p>
                <p class="mb-3">8488070737</p>

                <!-- Social Icons -->
                <div class="d-flex gap-3 fs-5">
                    <a href="#" class="text-dark"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-dark"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-dark"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-dark"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="text-dark"><i class="fab fa-pinterest"></i></a>
                </div>
            </div>

            <!-- Column 2: Company -->
            <div class="col-md-2 mb-4">
                <h6 class="fw-bold mb-3">COMPANY</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('Aboutus') }}" class="text-dark text-decoration-none d-block mb-2">About Us</a></li>
                    <li><a href="#" class="text-dark text-decoration-none d-block mb-2">Careers</a></li>
                    <li><a href="#" class="text-dark text-decoration-none d-block mb-2">Affiliates</a></li>
                    <li><a href="#" class="text-dark text-decoration-none d-block mb-2">Blog</a></li>
                    <li><a href="{{ route('Contact') }}" class="text-dark text-decoration-none d-block">Contact Us</a></li>
                </ul>
            </div>

            <!-- Column 3: Shop -->
            <div class="col-md-2 mb-4">
                <h6 class="fw-bold mb-3">SHOP</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-dark text-decoration-none d-block mb-2">New Arrivals</a></li>
                    <li><a href="#" class="text-dark text-decoration-none d-block mb-2">Accessories</a></li>
                    <li><a href="{{ route('shop') }}" class="text-dark text-decoration-none d-block mb-2">Laptop</a></li>
                    <li><a href="{{ route('shop') }}" class="text-dark text-decoration-none d-block mb-2">Airbuds</a></li>
                    <li><a href="{{ route('shop') }}" class="text-dark text-decoration-none d-block">Shop All</a></li>
                </ul>
            </div>

            <!-- Column 4: Help -->
            <div class="col-md-2 mb-4">
                <h6 class="fw-bold mb-3">HELP</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-dark text-decoration-none d-block mb-2">Customer Service</a></li>
                    <li><a href="{{ route('Profile') }}" class="text-dark text-decoration-none d-block mb-2">My Account</a></li>
                    <li><a href="#" class="text-dark text-decoration-none d-block mb-2">Find a Store</a></li>
                    <li><a href="#" class="text-dark text-decoration-none d-block mb-2">Legal & Privacy</a></li>
                    <li><a href="#" class="text-dark text-decoration-none d-block">Gift Card</a></li>
                </ul>
            </div>

            <!-- Column 5: Categories -->
            <div class="col-md-3 mb-4">
                <h6 class="fw-bold mb-3">CATEGORIES</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('shop') }}" class="text-dark text-decoration-none d-block mb-2">Oppo</a></li>
                    <li><a href="{{ route('shop') }}" class="text-dark text-decoration-none d-block mb-2">Vivo</a></li>
                    <li><a href="{{ route('shop') }}" class="text-dark text-decoration-none d-block mb-2">Apple</a></li>
                    <li><a href="{{ route('shop') }}" class="text-dark text-decoration-none d-block mb-2">Lenovo</a></li>
                    <li><a href="{{ route('shop') }}" class="text-dark text-decoration-none d-block">Shop All</a></li>
                </ul>
            </div>

        </div>

        <!-- Bottom -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center border-top pt-3 mt-3">
            <p class="mb-2 mb-md-0">©2025 Yusuf Vhora</p>
            <div class="text-center text-md-end">
                <a href="#" class="text-dark text-decoration-none">Privacy Policy</a> |
                <a href="#" class="text-dark text-decoration-none">Terms & Conditions</a>
            </div>
        </div>

    </div>
</footer>


<script src="https://checkout.razorpay.com/v1/checkout.js"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
 @stack('scripts')

 <script>
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
