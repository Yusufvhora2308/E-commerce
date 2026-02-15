@extends('layouts.app')

@section('title', 'Edit Category')

@section('main')

<div class="container mt-4" style="max-width: 700px;">

    {{-- Header with Back Button --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Edit Category</h3>

        <a href="{{ route('admin.showcategory') }}" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow p-4">
        <form action="{{ route('admin.category.update', $category->id) }}" 
              method="POST" enctype="multipart/form-data">

            @csrf

            {{-- Category Name --}}
            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" 
                       name="name" 
                       class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name', $category->name) }}">

                @error('name') 
                    <div class="invalid-feedback">{{ $message }}</div> 
                @enderror
            </div>

            {{-- Brand --}}
            <div class="mb-3">
                <label class="form-label">Select Brand</label>
                <select name="brand_id" class="form-control">
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}"
                            {{ $category->brand_id == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Current Image --}}
            <div class="mb-3">
                <label class="form-label d-block">Prview Image</label>
                <img id="previewImage"
                     src="{{ asset('uploads/categories/' . $category->image) }}"
                     width="90"
                     class="border rounded">
            </div>

            {{-- Upload New Image --}}
            <div class="mb-3">
                <label class="form-label">Category Image</label>
                <input type="file" 
                       name="image" 
                       id="imageInput"
                       class="form-control @error('image') is-invalid @enderror">

                @error('image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="d-flex gap-2">
                <button class="btn btn-primary w-100">
                    Update Category
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('imageInput');
    const previewImage = document.getElementById('previewImage');

    imageInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            previewImage.src = URL.createObjectURL(this.files[0]);
        }
    });
});
</script>
@endpush
