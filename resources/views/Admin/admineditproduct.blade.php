@extends('layouts.app')

@section('title', 'Edit Product')


@section('content')

<div class="container d-flex justify-content-center mt-5">

    <div class="card shadow border-0 w-100" style="max-width: 900px;">
        
        <div class="card-header bg-warning text-white text-center py-3">
            <h4 class="mb-0">✏️ Edit Product</h4>
        </div>

        <div class="card-body p-4">

            @if(Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif

            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Product Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Product Name</label>
                        <input type="text" name="name"
                               value="{{ old('name', $product->name) }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Enter product name">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                <!-- Description -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" rows="4"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Write product description...">{{ Str::limit(strip_tags($product->description), 80) }}
</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <!-- Price -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Price (₹)</label>
                        <input type="number" step="0.01" name="price"
                               value="{{ old('price', $product->price) }}"
                               class="form-control @error('price') is-invalid @enderror"
                               placeholder="Enter price">
                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Discount -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Discount (%)</label>
                        <input type="number" step="0.01" name="discount"
                               value="{{ old('discount', $product->discount) }}"
                               class="form-control @error('discount') is-invalid @enderror"
                               placeholder="0 - 100%">
                        @error('discount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Stock -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Stock</label>
                        <input type="number" name="stock" min="0"
                               value="{{ old('stock', $product->stock) }}"
                               class="form-control @error('stock') is-invalid @enderror"
                               placeholder="Enter available stock">
                        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Image -->
                <div class="mb-3">
                   <label class="form-label fw-bold">Add More Images</label>
<input type="file"
       name="images[]"
       id="imageInput"
       multiple
       class="form-control">
@error('images')
    <div class="text-danger mt-1">{{ $message }}</div>
@enderror

       <div class="row mt-3" id="previewContainer"></div>



               @if($product->images->count())
<hr>
<h6 class="fw-bold">Existing Images</h6>

<div class="row" id="existingImages">
@foreach($product->images as $img)
    <div class="col-md-2 text-center mb-3" id="img-{{ $img->id }}">
        <img src="{{ asset('uploads/products/'.$img->image) }}"
             class="img-fluid rounded mb-2"
             style="height:120px;object-fit:cover;">

        <button type="button"
                class="btn btn-danger btn-sm"
                onclick="removeExistingImage({{ $img->id }})">
            Remove
        </button>
    </div>
@endforeach
</div>
@endif


                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <!-- Weight -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Weight</label>
                        <input type="text" name="weight"
                               value="{{ old('weight', $product->weight) }}"
                               class="form-control @error('weight') is-invalid @enderror"
                               placeholder="e.g. 500g, 1kg">
                        @error('weight') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Dimensions -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Dimensions</label>
                        <input type="text" name="dimensions"
                               value="{{ old('dimensions', $product->dimensions) }}"
                               class="form-control @error('dimensions') is-invalid @enderror"
                               placeholder="e.g. 10x20x5 cm">
                        @error('dimensions') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Warranty -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Warranty</label>
                        <input type="text" name="warranty"
                               value="{{ old('warranty', $product->warranty) }}"
                               class="form-control @error('warranty') is-invalid @enderror"
                               placeholder="6 months, 1 year">
                        @error('warranty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Rating -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Rating</label>
                        <input type="number" name="rating" step="0.1" min="0" max="5"
                               value="{{ old('rating', $product->rating) }}"
                               class="form-control @error('rating') is-invalid @enderror"
                               placeholder="0 - 5">
                        @error('rating') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Brand -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Brand</label>
                        <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                            <option value="">-- Select Brand --</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Category -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Category</label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

<div class="d-flex gap-2 mt-3">
    <button type="submit" class="btn btn-warning w-100 py-2 fw-bold">
        Update Product
    </button>

    <a href="{{ route('admin.showproduct') }}"
       class="btn btn-outline-secondary w-100 py-2 fw-bold">
        Cancel
    </a>
</div>


            </form>
        </div>
    </div>
</div>

<script>
function removeExistingImage(id) {

    fetch("{{ route('product.image.delete', '') }}/" + id, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            _method: 'DELETE'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('img-' + id).remove();
        }
    })
    .catch(error => console.error(error));
}
let selectedFiles = [];

document.getElementById('imageInput').addEventListener('change', function (e) {
    selectedFiles = Array.from(e.target.files);
    renderPreview();
});

function renderPreview() {
    const preview = document.getElementById('previewContainer');
    preview.innerHTML = '';

    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = e => {
            preview.innerHTML += `
                <div class="col-md-2 text-center mb-3">
                    <img src="${e.target.result}"
                         class="img-fluid rounded border"
                         style="height:120px;object-fit:cover;">
                </div>
            `;
        };
        reader.readAsDataURL(file);
    });
}

</script>



@endsection
