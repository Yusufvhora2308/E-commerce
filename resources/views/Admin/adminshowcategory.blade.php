@extends('layouts.app')

@section('title','Admin / Category List')

@section('content')

@php
/** @var \Illuminate\Pagination\LengthAwarePaginator $categories */
@endphp


<style>
   
    .page-wrapper {
    width: 100%;
    transition: all 0.3s ease;
}

    /* Card */
    .category-card {
            width: 100%;
    max-width: 1200px;
        background: #fff;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    margin: auto;

    }

    /* Title */
    .page-title {
        text-align: center;
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 30px;
    }

    /* Search */
    .search-input {
        border-radius: 10px 0 0 10px;
    }

    .search-btn {
        border-radius: 0 10px 10px 0;
    }

    /* Table */
    .category-table thead th {
        background: #212529 !important;
        color: white;
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: .5px;
    }

    .category-table tbody tr:hover {
        background: #f4f4f4 !important;
        transition: .3s ease-in-out;
    }

    .category-img {
        width: 65px;
        height: 65px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid #ddd;
    }

    .action-btn {
        width: 85px;
        margin: 2px;
    }
</style>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: "{{ session('success') }}",
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif


<div class="page-wrapper">

    <div class="category-card">

        <h2 class="page-title">Category List</h2>

        <div class="d-flex justify-content-between mb-4">

            <a href="{{ route('admin.category') }}" class="btn btn-success px-4">
                <i class="fa fa-plus"></i> Add Category
            </a>

            <form action="{{ route('admin.showcategory') }}" method="GET" class="d-flex">
    <input type="text" name="search" class="form-control search-input"
           placeholder="Search category...">

    <button class="btn btn-dark search-btn px-3">
        <i class="fa fa-search"></i>
    </button>

    <a href="{{ route('admin.showcategory') }}" 
       class="btn btn-secondary px-3 ms-2">
        <i class="fa fa-times"></i>
    </a>
</form>


        </div>

        <table class="table table-striped table-bordered text-center category-table">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Category Name</th>
                    <th>Brand</th>
                    <th width="90">Image</th>
                    <th width="180">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($categories as $category)
                <tr>
                 <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</td>

                    <td class="fw-bold">{{ $category->name }}</td>

                       <td>
        <span class="badge bg-info">
            {{ $category->brand->name ?? 'No Brand' }}
        </span>
    </td>

                    <td>
                        <img src="{{ asset('uploads/categories/' . $category->image) }}" class="category-img">
                    </td>

                    <td>
                        <a href="{{ route('admin.category.edit',$category->id) }}"
                           class="btn btn-primary btn-sm action-btn">
                            <i class="fa fa-edit"></i> Edit
                        </a>

                       <form action="{{ route('admin.category.delete', $category->id) }}"
      method="POST"
      class="d-inline delete-category-form">
    @csrf
    @method('DELETE')

    <button type="button"
            class="btn btn-danger btn-sm delete-category-btn"
            data-name="{{ $category->name }}">
        <i class="fa fa-trash"></i>
    </button>
</form>

                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="4" class="text-muted py-4">
                        <i class="fa fa-folder-open fa-2x mb-2"></i><br>
                        No categories found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-4">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // CATEGORY DELETE
    document.querySelectorAll('.delete-category-btn').forEach(button => {

        button.addEventListener('click', function () {

            let form = this.closest('.delete-category-form');
            let name = this.dataset.name;

            Swal.fire({
                title: 'Are you sure?',
                text: `Category "${name}" will be permanently deleted!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

        });

    });

});
</script>

@endsection
