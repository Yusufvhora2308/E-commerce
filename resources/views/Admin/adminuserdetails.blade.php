@extends('layouts.app')

@section('title','Admin / User List')

@section('content')

<style>
    .user-card {
        background: #ffffff;
        border-radius: 15px;
        padding: 30px;
        width: 95%;
        max-width: 1200px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        transition: 0.3s;
        margin: auto;
    }

    .user-card:hover {
        transform: scale(1.01);
    }

    .user-table thead th {
        background: #212529 !important;
        color: #fff;
        font-size: 14px;
        text-transform: uppercase;
        padding: 12px;
        letter-spacing: .5px;
    }

    .user-table tbody tr:hover {
        background: #f8f9fa !important;
        transition: 0.2s;
    }

    .search-input {
        width: 300px;
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 8px 12px;
    }

    .page-title {
        font-size: 26px;
        font-weight: 700;
        color: #333;
        text-align: center;
        margin-bottom: 25px;
    }

    .badge-role {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 6px;
    }

    .pagination .page-link {
        color: #212529;
    }

    .pagination .page-item.active .page-link {
        background-color: #212529;
        border-color: #212529;
    }
</style>

<div class="user-card mt-4">

    <h3 class="page-title">User List</h3>


    <!-- Search -->
    <div class="d-flex justify-content-end mb-3">
        <form action="{{ route('admin.userdetail') }}" method="GET" class="d-flex">
            <input type="text" 
                   name="search" 
                   class="form-control search-input"
                   placeholder="Search user..."
                   value="{{ request('search') }}">

            <button type="submit" class="btn btn-dark ms-2">
                <i class="fas fa-search"></i>
            </button>

            <a href="{{ route('admin.userdetail') }}" class="btn btn-secondary ms-2">
                <i class="fas fa-times"></i>
            </a>
        </form>
    </div>

    <table class="table table-bordered table-hover text-center user-table mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>User Info</th>
                <th>Email</th>
                <th>Registered</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>

                <td class="fw-bold text-start">
                    {{ $user->name }}
                </td>

                <td>{{ $user->email }}</td>

                <td>{{ $user->created_at->format('d M Y') }}</td>

              <td>
    <a href="javascript:void(0);" 
       class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-danger' }}"
       onclick="changeStatus('{{ route('admin.user.status', $user->id) }}')">
       {{ ucfirst($user->status) }}
    </a>
</td>


                <td>
                    <a href="{{ route('admin.user.view', $user->id) }}" 
                       class="btn btn-primary btn-sm">
                        View
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted">No users found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-3 d-flex justify-content-center">
        {{ $users->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>

</div>

<script>
function changeStatus(url) {
    Swal.fire({
        title: 'Are you sure?',
        text: "User status change karna hai?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, change it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}
</script>

@endsection
