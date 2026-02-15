@extends('layouts.app')

@section('title','Admin/Products')

@section('content')



<style>
/* PAGE WRAPPER */
.page-wrapper {
 /* space for sidebar */
    padding: 20px;
}

/* CARD CONTAINER */
.card-custom {
    background: #ffffff;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

/* TABLE */
.table thead th {
    background: #343a40 !important;
    color: #fff;
    font-size: 13px;
    text-transform: uppercase;
    padding: 10px;
}

.table tbody tr:hover {
    background: #f1f1f1;
    transition: 0.2s;
}

/* IMAGE STYLE */
.product-img {
    border-radius: 8px;
    border: 1px solid #ddd;
}

/* BUTTONS */
.btn-sm i {
    font-size: 14px;
}

/* PAGINATION */
.pagination {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 5px 12px;
    background: #fafafa;
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

/* CUSTOM PAGINATION DESIGN */
.custom-pagination .page-link {
    color: #343a40;
    border: none;
    padding: 10px 16px;
    margin: 0 4px;
    font-weight: 600;
    border-radius: 8px;
    background: #f2f2f2;
    transition: 0.3s;
}

.custom-pagination .page-item.active .page-link {
    background: #0d6efd;
    color: #fff;
    box-shadow: 0 3px 8px rgba(0, 114, 255, 0.3);
}

.custom-pagination .page-link:hover {
    background: #e0e0e0;
}

.custom-pagination .page-item.disabled .page-link {
    background: #e9ecef;
    color: #999;
}

.product-img {
    object-fit: cover;
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


    <div class="card-custom">

        <!-- HEADER WITH SEARCH + ADD BUTTON -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <h3 class="fw-bold text-dark">Product List</h3>

            <div class="d-flex">

                <!-- Search -->
               <form action="{{ route('admin.showproduct') }}" method="GET" class="d-flex">
    <input type="text" name="search" class="form-control"
           placeholder="Search products...">

    <button type="submit" class="btn btn-dark ms-2">
        <i class="fas fa-search"></i>
    </button>

    <a href="{{ route('admin.showproduct') }}" 
       class="btn btn-secondary ms-2">
        <i class="fas fa-times"></i>
    </a>
</form>


                <!-- Add Button -->
                <a href="{{ route('admin.addproduct') }}" class="btn btn-success ms-4">
                    <i class="fas fa-plus"></i> Add Product
                </a>

            </div>
        </div>

        <!-- PRODUCT TABLE -->
         <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
<tbody>
@forelse($products as $prod)
<tr>
    <td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>

    <td class="fw-bold">{{ $prod->name }}</td>
    <td>₹{{ $prod->price }}</td>
    <td>{{ $prod->stock }}</td>

    <td>{{ $prod->brand->name ?? '-' }}</td>
    <td>{{ $prod->category->name ?? '-' }}</td>

    <!-- IMAGES -->
    <td>
        @if($prod->images->count())
            <div class="d-flex justify-content-center gap-1 flex-wrap">
                @foreach($prod->images->take(3) as $img)
                    <img src="{{ asset('uploads/products/'.$img->image) }}"
                         width="45" height="45"
                         class="product-img">
                @endforeach
            </div>
        @else
            -
        @endif
    </td>

    <!-- ACTIONS -->
    <td>
        <a href="{{ route('products.edit', $prod->id) }}"
           class="btn btn-primary btn-sm mb-1">
            <i class="fas fa-edit"></i>
        </a>

        <form action="{{ route('products.delete', $prod->id) }}"
      method="POST"
      class="d-inline delete-form">
    @csrf
    @method('DELETE')

    <button type="button"
            class="btn btn-danger btn-sm delete-btn">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>

    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-muted text-center">
        No products found.
    </td>
</tr>
@endforelse
</tbody>

        </table>
</div>
        <!-- PAGINATION -->
      <div class="mt-4 d-flex justify-content-center">
    <div class="custom-pagination">
        {{ $products->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>
</div>


    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.delete-btn').forEach(button => {

        button.addEventListener('click', function () {

            let form = this.closest('.delete-form');

            Swal.fire({
                title: 'Are you sure?',
                text: "This product will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // ✅ form submit
                }
            });

        });

    });

});
</script>


@endsection
