@extends('layouts.app')

@section('title','Edit User')

@section('content')

<style>
    .edit-card {
        background: #ffffff;
        padding: 35px;
        border-radius: 18px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 1px solid #e5e7eb;
        width: 700px;
    }

    .edit-title {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 25px;
        text-align: center;
        color: #333;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
    }

    .form-control {
        height: 48px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
    }

    .btn-update {
        width: 100%;
        height: 48px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 10px;
    }
</style>


<div class="container mt-5 py-5" style="max-width: 850px;">

    <div class="edit-card">

        <h3 class="edit-title">Edit User Details</h3>

        <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name"
                       value="{{ $user->name }}" 
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email"
                       value="{{ $user->email }}" 
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-control">
                    <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success btn-update">
                Update User
            </button>

        </form>

    </div>

</div>

@endsection
