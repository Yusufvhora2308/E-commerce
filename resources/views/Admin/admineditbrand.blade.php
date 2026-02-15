@extends('layouts.app')

@section('title', 'Edit Brand')

@section('main')

<div class="container mt-4" style="max-width: 700px;">

    {{-- Header with Back Button --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Edit Brand</h3>

        <a href="{{ route('admin.showbrand') }}" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">

            <form action="{{ route('admin.brand.update', $brand->id) }}" 
                  method="POST" enctype="multipart/form-data">

                @csrf

                {{-- Name --}}
                <div class="mb-3">
                    <label class="form-label">Brand Name</label>
                    <input type="text" 
                           name="name" 
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $brand->name) }}">

                    @error('name') 
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control"
                              name="description"
                              rows="3">{{ strip_tags($brand->description) }}</textarea>

                    @error('description') 
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Current Image --}}
                <div class="mb-3">
                    <label class="form-label">Prview Image</label><br>
                    <img id="imagePreview"
                         src="{{ asset('uploads/brands/'.$brand->image) }}"
                         width="120"
                         class="border rounded mb-2">
                </div>

                {{-- Upload New Image --}}
                <div class="mb-3">
                    <label class="form-label">Upload New Image (Optional)</label>
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
                        Update Brand
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush
