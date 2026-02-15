@extends('layouts.app')

@section('title','Admin/Brand')

@section('main')

<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card p-4 shadow" style="width: 700px; background-color: #f8f9fa; border-radius: 15px;">
        <h3 class="text-center mb-4" style="color:#343a40;">Add New Brand</h3>

        
            @if(Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif

            @if(Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif

        <form action="{{ route('admin.brandvalidate') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Brand Name --}}
            <div class="mb-3">
                <label for="name" class="form-label" style="color:#495057;">Brand Name</label>
                <input type="text" 
                    class="form-control @error('name') is-invalid @enderror" 
                    id="name" name="name" value="{{ old('name') }}">
                @error('name') 
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
<div class="mb-3">
    <label class="form-label fw-semibold">Description / Note</label>

    <textarea
        class="form-control @error('description') is-invalid @enderror"
        id="description"
        name="description"
        rows="5">{{ old('description') }}</textarea>

    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- IMAGE PREVIEW --}}
<div class="mb-3 text-center">
    <img id="imagePreview"
         src="{{ asset('images/no-image.png') }}"
         style="max-width: 200px; max-height: 200px; display: none;"
         class="img-thumbnail mb-2">
</div>


            {{-- Image --}}
            <div class="mb-3">
                <label for="image" class="form-label" style="color:#495057;">Brand Image (Max 2MB)</label>
                <input type="file" 
                    class="form-control @error('image') is-invalid @enderror" 
                    id="image" name="image" accept="image/*">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Save Brand</button>
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
