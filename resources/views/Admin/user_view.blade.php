@extends('layouts.app')

@section('title','Admin / View User')

@section('content')

<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <h3 class="mb-4">User Details</h3>

        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <td>{{ $user->name }}</td>
            </tr>

            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>

            <tr>
                <th>Registered On</th>
                <td>{{ $user->created_at->format('d M Y, H:i') }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    <span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                        {{ ucfirst($user->status) }}
                    </span>
                </td>
            </tr>

            <tr>
                <th>Actions</th>
                <td>
                    <a href="{{ route('admin.user.status', $user->id) }}"
                       class="btn btn-sm btn-warning"
                       onclick="return confirm('Change user status?')">
                       Toggle Status
                    </a>

                    <a href="{{ route('admin.userdetail') }}" class="btn btn-sm btn-secondary">
                        Back to List
                    </a>
                </td>
            </tr>
        </table>
    </div>
</div>

@endsection
