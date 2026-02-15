@extends('layouts.app')

@section('title','Add Product')


@section('content')

<div class="container d-flex justify-content-center mt-5">

    <div class="card shadow border-0 w-100" style="max-width: 900px;">
        
        <div class="card-header bg-primary text-white text-center py-3">
            <h4 class="mb-0"> Add New Product</h4>
        </div>

        <div class="card-body p-4">

                
            @if(Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif

            @if(Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif

            <form action="{{ route('admin.productstore') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <!-- Product Name -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Product Name</label>
                        <input type="text" name="name"
                               value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Enter product name">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>


               <!-- Description -->
<div class="mb-3">
    <label class="form-label fw-bold">Description</label>

    <textarea
        id="description"
        name="description"
        rows="4"
        class="form-control @error('description') is-invalid @enderror"
        placeholder="Write product description...">{{ old('description') }}</textarea>

    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


                <div class="row">
                    <!-- Price -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Price (₹)</label>
                        <input type="number" step="0.01" name="price"
                               value="{{ old('price') }}"
                               class="form-control @error('price') is-invalid @enderror"
                               placeholder="Enter price">
                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Discount -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Discount (%)</label>
                        <input type="number" step="0.01" name="discount"
                               value="{{ old('discount') }}"
                               class="form-control @error('discount') is-invalid @enderror"
                               placeholder="0 - 100%">
                        @error('discount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
<!-- Stock -->
<div class="col-md-4 mb-3">
    <label class="form-label fw-bold">Stock</label>
    <input type="number" name="stock" min="0"
           value="{{ old('stock') }}"
           class="form-control @error('stock') is-invalid @enderror"
           placeholder="Enter available stock">
    @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>


                <!-- Image -->
               <div class="mb-3">
    <label class="form-label fw-bold">Product Images</label>

    <input type="file"
           name="images[]"
           id="imageInput"
           class="form-control @error('images') is-invalid @enderror"
           multiple
           accept="image/*">

    @error('images') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<!-- Preview Area -->
<div class="row" id="previewContainer"></div>


                <div class="row">
    <!-- Weight -->
    <div class="col-md-3 mb-3">
        <label class="form-label fw-bold">Weight</label>
        <input type="text" name="weight"
               value="{{ old('weight') }}"
               class="form-control @error('weight') is-invalid @enderror"
               placeholder="e.g. 500g, 1kg">
        @error('weight') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <!-- Dimensions -->
    <div class="col-md-3 mb-3">
        <label class="form-label fw-bold">Dimensions</label>
        <input type="text" name="dimensions"
               value="{{ old('dimensions') }}"
               class="form-control @error('dimensions') is-invalid @enderror"
               placeholder="e.g. 10x20x5 cm">
        @error('dimensions') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <!-- Warranty -->
    <div class="col-md-3 mb-3">
        <label class="form-label fw-bold">Warranty</label>
        <input type="text" name="warranty"
               value="{{ old('warranty') }}"
               class="form-control @error('warranty') is-invalid @enderror"
               placeholder="6 months, 1 year">
        @error('warranty') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <!-- Rating -->
    <div class="col-md-3 mb-3">
        <label class="form-label fw-bold">Rating</label>
        <input type="number" name="rating" step="0.1" min="0" max="5"
               value="{{ old('rating') ?? 0 }}"
               class="form-control @error('rating') is-invalid @enderror"
               placeholder="0 - 5">
        @error('rating') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>


                <div class="row">
                    <!-- Brand -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Brand</label>
                        <select name="brand_id"
                                class="form-control @error('brand_id') is-invalid @enderror">
                            <option value="">-- Select Brand --</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Category -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Category</label>
                        <select name="category_id"
                                class="form-control @error('category_id') is-invalid @enderror">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>



                <!-- Featured -->
                <!-- <div class="form-check mb-4">
                    <input type="checkbox" name="featured" class="form-check-input"
                           {{ old('featured') ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold">Mark as Featured</label>
                </div> -->

                <!-- Submit -->
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                    Save Product
                </button>

            </form>
        </div>
    </div>

</div>
<script>
let selectedFiles = [];

document.getElementById('imageInput').addEventListener('change', function (e) {
    const files = Array.from(e.target.files);

    files.forEach(file => {
        selectedFiles.push(file);
    });

    renderPreview();
});

function renderPreview() {
    const preview = document.getElementById('previewContainer');
    preview.innerHTML = '';

    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.innerHTML += `
                <div class="col-md-2 text-center mb-3">
                    <img src="${e.target.result}" class="img-fluid rounded border" style="height:120px;object-fit:cover;">
                    <button type="button"
                            class="btn btn-sm btn-danger mt-2"
                            onclick="removeImage(${index})">
                        Remove
                    </button>
                </div>
            `;
        };

        reader.readAsDataURL(file);
    });

    updateFileInput();
}

function removeImage(index) {
    selectedFiles.splice(index, 1);
    renderPreview();
}

function updateFileInput() {
    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(file => dataTransfer.items.add(file));
    document.getElementById('imageInput').files = dataTransfer.files;
}
</script>

@endsection
