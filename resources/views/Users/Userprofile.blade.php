@extends('layouts.user')

@section('title', 'User Profile')

@section('content')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h2 class="display-5 fw-bold mb-4 text-center">My Profile</h2>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- ================= PROFILE DETAILS ================= --}}
            <div class="card shadow-sm mb-5">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3">Account Information</h4>
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $user->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $user->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-dark mt-2">Update Profile</button>
                    </form>
                </div>
            </div>

         
    
</div>


        </div>
    </div>
</div>
@endsection
