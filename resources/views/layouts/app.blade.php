<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" 
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    

    <style>
        body { background: #f8f9fc; }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            background: #fff;
            border-right: 1px solid #e4e4e4;
            transition: all .3s ease;
            padding-top: 15px;
        }
        .sidebar.closed { margin-left: -260px; }

        .sidebar .nav-link {
            padding: 12px 20px;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #f1f1f1;
            font-weight: bold;
        }

        .content-wrapper {
            margin-left: 260px;
            padding: 20px;
            transition: .3s ease;
        }
        .content-wrapper.full { margin-left: 0; }

        /* SUBMENU PLAIN STYLE */
        .submenu {
            list-style: none;
            padding-left: 45px;
            margin-top: 5px;
        }
        .submenu li {
            padding: 4px 0;
        }
        .submenu a {
            color: #555;
            font-size: 14px;
            text-decoration: none;
        }
        .submenu a:hover {
            color: #000;
        }


        .pagination {
    border: 1px solid #c9c9c9;
    padding: 5px 10px;
    border-radius: 4px;
    background: #f8f8f8;
}

/* Pagination buttons */
.pagination .page-link {
    border: 1px solid #c9c9c9 !important;
    background: #ffffff !important;
    color: #333 !important;
    margin: 0 3px !important;
    padding: 4px 12px !important;
    font-size: 14px !important;
}

/* Active page */
.pagination .active .page-link {
    background: #1a73e8 !important;
    color: #fff !important;
    border-color: #1a73e8 !important;
    font-weight: bold;
}

/* Hover */
.pagination .page-link:hover {
    background: #e7e7e7 !important;
    color: #000 !important;
}
    </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">

    <div class="text-center mb-4">
        <a href="{{ route('admin.dashboard') }}">  <img src="/IMAGES/E COMMERCE LOGO.jpg" alt="Logo" class="img-fluid" style="max-height: 100px;"></a>
    </div> 

   <nav class="nav flex-column mt-3">

    <!-- DASHBOARD -->
    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
       href="{{ route('admin.dashboard') }}">
        <i class="fa-solid fa-gauge-high"></i> Dashboard
    </a>

    <!-- USERS -->
    <a class="nav-link {{ request()->routeIs('admin.userdetail') ? 'active' : '' }}"
       href="{{ route('admin.userdetail') }}">
        <i class="fa-solid fa-users"></i> Users
    </a>

    <!-- BRAND -->
    <a class="nav-link {{ request()->routeIs('admin.showbrand*') ? 'active' : '' }}"
       href="{{ route('admin.showbrand') }}">
        <i class="fa-solid fa-tags"></i> Brand
    </a>

    <!-- CATEGORY -->
    <a class="nav-link {{ request()->routeIs('admin.showcategory*') ? 'active' : '' }}"
       href="{{ route('admin.showcategory') }}">
        <i class="fa-solid fa-list"></i> Category
    </a>

    <!-- PRODUCTS -->
    <a class="nav-link {{ request()->routeIs('admin.showproduct*') ? 'active' : '' }}"
       href="{{ route('admin.showproduct') }}">
        <i class="fa-solid fa-cart-shopping"></i> Products
    </a>

    <!-- ORDERS -->
    <a class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}"
       href="{{ route('admin.orders') }}">
        <i class="fa-solid fa-bag-shopping"></i> Orders
    </a>

    <!-- SHIPPING CHARGE -->
    <a class="nav-link {{ request()->routeIs('shipping.*') ? 'active' : '' }}"
       href="{{ route('shipping.index') }}">
        <i class="fa-regular fa-comment-dots"></i> Shipping Charge
    </a>

    <!-- FEEDBACK -->
    <a class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}"
       href="{{ route('contact.index') }}">
        <i class="fa-regular fa-comment-dots"></i> Feedback List
    </a>

    <!-- SETTINGS -->
    <a class="nav-link {{ request()->routeIs('admin.setting') ? 'active' : '' }}"
       href="{{ route('admin.setting') }}">
        <i class="fa-solid fa-gear"></i> Settings
    </a>

    <!-- LOGOUT -->
    <a class="nav-link text-danger" href="{{ route('admin.logout') }}">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>

</nav>

</div>


<!-- MAIN CONTENT -->
<div class="content-wrapper">


    <!-- NAVBAR -->
    <nav class="navbar navbar-light bg-white shadow-sm mb-4 p-3 rounded d-flex align-items-center justify-content-between">

        <!-- Toggle Button -->
        <button class="btn btn-light me-3" id="toggleSidebar">
            <i class="fa-solid fa-bars fs-4"></i>
        </button>

        <!-- Search Bar -->
        <form class="d-flex mx-auto" style="width: 700px; max-width: 100%;">
      

            
        </form>

      
        </nav>
        
@section('content')

@show


</div>

@section('main')

@show






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById('toggleSidebar').addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('closed');
        document.querySelector('.content-wrapper').classList.toggle('full');
    });
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/41.3.0/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: [
                'bold', 'italic', 'underline',
                '|',
                'bulletedList', 'numberedList',
                '|',
                'undo', 'redo'
            ]
        })
        .then(editor => {
            editor.model.document.on('change:data', () => {
                // Optional: Plain text trim
                // console.log(editor.getData());
            });
        })
        .catch(error => {
            console.error(error);
        });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif

 @stack('scripts')
</body>
</html>
