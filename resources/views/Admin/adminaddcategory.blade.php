@extends('layouts.app')

@section('title','Add Category')

@section('main')
<div class="d-flex justify-content-center">
    <div class="card p-4 shadow" style="width: 700px; background-color: #f8f9fa; border-radius: 15px;">
        <h3 class="text-center mb-4" style="color:#343a40;">Add New Category</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.categorystore') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                @error('name') <p class="text-danger ">{{ $message }}</p> @enderror
            </div>

       <div class="mb-3">
    <label class="form-label fw-semibold">Select Brand</label>

    <select name="brand_id"
            class="form-select @error('brand_id') is-invalid @enderror">
        <option value="">-- Choose Brand --</option>

        @foreach($brands as $brand)
            <option value="{{ $brand->id }}"
                {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                {{ $brand->name }}
            </option>
        @endforeach
    </select>

    @error('brand_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- IMAGE PREVIEW --}}
<div class="mb-3 text-center">
    <img id="imagePreview"
         src="{{ asset('images/no-image.png') }}"
         class="img-thumbnail"
         style="max-width: 200px; max-height: 200px; display: none;">
</div>


            <div class="mb-3">
                <label for="image" class="form-label">Category Image (Max 2MB)</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                @error('image') <p class="text-danger">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Save Category</button>
        </form>
    </div>
</div>


@push('scripts')
<script>
document.getElementById('image').addEventListener('change', function (e) {

    const preview = document.getElementById('imagePreview');
    const file = e.target.files[0];

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    } else {
        preview.src = '';
        preview.style.display = 'none';
    }
});
</script>
@endpush

@endsection
