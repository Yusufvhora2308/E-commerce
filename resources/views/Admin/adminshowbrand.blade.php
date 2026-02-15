@extends('layouts.app')

@section('title','Admin | Brand List')

@section('content')

<style>



/* CARD */
.brand-card {
    width: 100%;
    max-width: 1200px;
    background: #ffffff;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    margin: auto;
}


/* TITLE */
.page-title {
    font-size: 26px;
    font-weight: 700;
    color: #2c2c2c;
    text-align: center;
    margin-bottom: 25px;
}

/* SEARCH BAR */
.search-box input {
    border-radius: 8px;
    border: 1px solid #ccc;
}

.search-box button {
    border-radius: 8px;
    padding: 0 15px;
}

/* TABLE */
.brand-table thead th {
    background: #343a40;
    color: #fff;
    font-size: 14px;
    text-transform: uppercase;
}

.brand-table tbody tr:hover {
    background: #f4f4f4;
    transition: .3s;
}

/* IMAGE */
.brand-img {
    border-radius: 10px;
    border: 2px solid #e0e0e0;
    object-fit: cover;
}

/* ACTION BUTTONS */
.action-btn {
    width: 70px;
}

.btn-sm i {
    font-size: 14px;
}

/* PAGINATION */
.pagination {
    border: 1px solid #ddd;
    padding: 6px 12px;
    border-radius: 6px;
    background: #f8f8f8;
}

.pagination .page-link {
    color: #333 !important;
    border-radius: 5px !important;
}

.pagination .active .page-link {
    background: #0d6efd !important;
    border-color: #0d6efd !important;
    color: #fff !important;
}
</style>

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


<div class="page-wrapper">

    <div class="brand-card">

        <h3 class="page-title">Brand List</h3>

        <!-- Add Button -->
        <div class="text-end mb-3">
            <a href="{{ route('admin.brand') }}" class="btn btn-success">
                <i class="fa fa-plus"></i> Add Brand
            </a>
        </div>

       <form action="{{ route('admin.showbrand') }}" method="GET" class="d-flex search-box mb-3">
    <input type="text" name="search" class="form-control"
           placeholder="Search brands...">
    
    <button type="submit" class="btn btn-dark ms-2">
        <i class="fas fa-search"></i>
    </button>

    <a href="{{ route('admin.showbrand') }}" class="btn btn-secondary ms-2">
        <i class="fas fa-times"></i>
    </a>
</form>


        <!-- TABLE -->
        <table class="table table-bordered table-hover text-center brand-table mt-4">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Brand Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th width="150px">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($brands as $brand)
                <tr>
                   <td>
    {{ ($brands->currentPage() - 1) * $brands->perPage() + $loop->iteration }}
</td>


                    <td class="fw-bold">{{ $brand->name }}</td>

             <td class="text-start">
    <div class="description-box text-center">
        {{ Str::limit(strip_tags($brand->description), 120) }}
    </div>
</td>


                    <td>
                        <img src="{{ asset('uploads/brands/' . $brand->image) }}"
                             width="60" height="60" class="brand-img">
                    </td>

                    <td>
                        <a href="{{ route('admin.brand.edit',$brand->id) }}" 
                           class="btn btn-primary btn-sm action-btn">
                            <i class="fa fa-edit"></i>
                        </a>
<form action="{{ route('admin.brand.delete', $brand->id) }}"
      method="POST"
      class="d-inline delete-brand-form">
    @csrf
    @method('DELETE')

    <button type="button"
            class="btn btn-danger btn-sm delete-btn"
            data-name="{{ $brand->name }}">
        <i class="fa fa-trash"></i>
    </button>
</form>


                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="text-muted">No brands found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-center mt-3">
            {{ $brands->appends(request()->all())->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-btn').forEach(function(btn) {
        btn.addEventListener('click', function () {
            let form = this.closest('form'); // Form reference
            let brandName = this.dataset.name; // Brand name for confirmation

            Swal.fire({
                title: `Delete ${brandName}?`,
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form
                }
            });
        });
    });
});
</script>
@endpush


@endsection
